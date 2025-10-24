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
use Symfony\Component\HttpFoundation\StreamedResponse;

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

   public function exportContacts(Request $request)
    {
        // ダウンロード時のファイル名を指定
        $fileName = 'contacts_' . now()->format('Ymd_His') . '.csv';

        $response = new StreamedResponse(function () {
            $stream = fopen('php://output', 'w');
            
            // 日本語・Excel対応のため、Shift-JISに変換し、改行コードをCRLFにするフィルターを設定
            stream_filter_prepend($stream, 'convert.iconv.utf-8/sjis-win');

            // ヘッダー行 (Contactテーブルのカラムに合わせて修正)
            $headers = [ '姓','名', '性別','メールアドレス', 'お問い合わせ内容'];
            fputcsv($stream, $headers);

            // Contactモデルからデータを1000件ずつ取得して処理 (メモリ効率が良い)
            Contact::query()->with('category')->chunk(1000, function ($contacts) use ($stream) {
                foreach ($contacts as $contact) {
                    $row = [
                        $contact->last_name,
                        $contact->first_name,
                        $contact->gender,
                        $contact->email,
                        $contact->category?->content,
                    ];
                    fputcsv($stream, $row);
                }
            });

            fclose($stream);
        });

        // レスポンスヘッダーの設定
        $response->headers->set('Content-Type', 'text/csv');
        $response->headers->set('Content-Disposition', 'attachment; filename="' . $fileName . '"');

        return $response;
    }
    
}