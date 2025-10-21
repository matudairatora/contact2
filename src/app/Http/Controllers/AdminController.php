<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\AdminRequest;
use App\Models\Contact;
use App\Models\Category;
use App\Models\User;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Response; 
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    public function index(Request $request)
{   
    Paginator::useBootstrap();
    // 1. カテゴリーデータを取得 (絞り込み用)
        $categories = Category::all();

        // 2. リクエストから検索・絞り込み条件を取得
        $keyword = $request->input('keyword');
        $gender = $request->input('gender');
        $category_id = $request->input('category_id');
        $content = $request->input('content');
        $date_start = $request->input('date_start');
        $date_end = $request->input('date_end');

        // 3. Contact モデルからデータを取得し、スコープを適用
        $contacts = Contact::with('category') // リレーションをロード
            ->keywordSearch($keyword)            // 姓、名、メールアドレス検索   
            ->contentSearch($content)    
            ->genderSearch($gender)           // 性別絞り込み
            ->categorySearch($category_id)    // カテゴリーID絞り込み
            ->dateStartSearch($date_start)    // 開始日検索
            ->dateEndSearch($date_end)        // 終了日検索
            ->paginate(7)                   // 1ページあたりの表示件数（画像に合わせ7件と仮定）
            ->withQueryString();              // ページネーションリンクに検索条件を引き継ぐ

           
                
           
    
       
        
        return view('auth.index', compact('contacts', 'categories'));
    }
    
    // 削除処理のメソッド (web.php にルートを追加する必要あり)
    public function delete(Request $request)
    {
        Contact::find($request->id)->delete();
        // 削除後、検索条件を保持して一覧ページに戻る
        return back(); 
    }


    public function exportCsv(Request $request)
    {
        // 1. CSVヘッダー行を定義
        $csvHeader = [
            'ID', '氏名', '性別', 'メールアドレス', '電話番号', 
            '住所', '建物名', 'お問い合わせの種類', '詳細', '登録日時'
        ];
        
        // 2. 検索・絞り込みロジックを再利用
        // index メソッドと同じロジックでクエリを構築します
        $contactsQuery = Contact::with('category')
            ->keywordSearch($request->input('keyword'))
            ->genderSearch($request->input('gender'))
            ->categorySearch($request->input('category_id'))
            ->contentSearch($content->input('content')) 
            ->dateStartSearch($request->input('date_start'))
            ->dateEndSearch($request->input('date_end'));
            
        // 3. 構築したクエリから全データを取得
        $contacts = $contactsQuery->get();

        // 4. ファイルポインタを開く
        $callback = function() use ($contacts, $csvHeader)
        {
            // PHPのテンポラリファイルを開く
            $file = fopen('php://output', 'w');
            
            // 日本語が文字化けしないように BOM を付ける
            fwrite($file, "\xEF\xBB\xBF"); 

            // ヘッダー行を書き込む
            fputcsv($file, $csvHeader);

            // データ行を書き込む
            foreach ($contacts as $contact) {
                // 性別コードをテキストに変換
                $genderText = match($contact->gender) {
                    1 => '男性',
                    2 => '女性',
                    default => 'その他',
                };
                
                // CSVの1行分の配列を作成
                fputcsv($file, [
                    $contact->id,
                    $contact->last_name . ' ' . $contact->first_name, // 氏名結合
                    $genderText,
                    $contact->email,
                    $contact->tel,
                    $contact->address,
                    $contact->building,
                    $contact->category->content ?? '不明', // カテゴリー名
                    $contact->detail,
                    $contact->created_at->format('Y/m/d H:i'), // 登録日時フォーマット
                ]);
            }
            
            fclose($file);
        };
        
        // 5. ダウンロード用のレスポンスヘッダーを設定
        $fileName = 'contacts_' . now()->format('YmdHis') . '.csv';
        
        return Response::stream($callback, 200, [
            'Content-Type'        => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"{$fileName}\"",
        ]);

    }
}