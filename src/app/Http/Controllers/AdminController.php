<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\AdminRequest;
use App\Models\Contact;
use App\Models\Category;
use App\Models\User;

class AdminController extends Controller
{
    public function index(Request $request)
{
    // 1. カテゴリーデータを取得 (絞り込み用)
        $categories = Category::all();

        // 2. リクエストから検索・絞り込み条件を取得
        $keyword = $request->input('keyword');
        $gender = $request->input('gender');
        $category_id = $request->input('category_id');
        $date_start = $request->input('date_start');
        $date_end = $request->input('date_end');

        // 3. Contact モデルからデータを取得し、スコープを適用
        $contacts = Contact::with('category') // リレーションをロード
            ->keywordSearch($keyword)         // 姓、名、メールアドレス検索
            ->genderSearch($gender)           // 性別絞り込み
            ->categorySearch($category_id)    // カテゴリーID絞り込み
            ->dateStartSearch($date_start)    // 開始日検索
            ->dateEndSearch($date_end)        // 終了日検索
            ->paginate(7)                     // 1ページあたりの表示件数（画像に合わせ7件と仮定）
            ->withQueryString();              // ページネーションリンクに検索条件を引き継ぐ

        // 4. ビューにデータを渡す
        return view('auth.index', compact('contacts', 'categories'));
    }
    
    // 削除処理のメソッド (web.php にルートを追加する必要あり)
    public function delete(Request $request)
    {
        Contact::find($request->id)->delete();
        // 削除後、検索条件を保持して一覧ページに戻る
        return back(); 
    }


}
