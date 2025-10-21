<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FashionablyLate | Admin</title>

    {{-- CSSの読み込み --}}
    
    <link rel="stylesheet" href="{{ asset('css/admin_index.css') }}">
<script>
    // ★ JavaScriptを追加し、検索条件をエクスポートURLに付与する ★
    document.getElementById('export-csv-button').addEventListener('click', function() {
        
        // CSV出力のベースURLをBladeヘルパーで取得
        // '{{ route("admin.export") }}' の部分は、BladeがPHPとして処理します。
        const baseUrl = '{{ route("admin.export") }}'; 
        
        // 現在の検索フォームの全てのクエリパラメータを取得
        const searchForm = document.getElementById('search-form');
        const formData = new FormData(searchForm);
        const params = new URLSearchParams();
        
        // FormDataから検索条件をパラメータとして追加
        for (const [key, value] of formData.entries()) {
            // リセットボタンの name や submitボタンなど不要なものを除外
            // value !== '' のチェックも重要
            if (key !== '_token' && value !== null && value !== '') {
                params.append(key, value);
            }
        }
        
        // 新しいURLを作成して遷移
        // パラメータがない場合は ? は付かない
        const exportUrl = baseUrl + (params.toString() ? '?' + params.toString() : '');

        // ダウンロード実行
        window.location.href = exportUrl;
    });
</script>
</head>
<body>

    {{-- ヘッダー領域 --}}
    <header class="header">
        <h1 class="header__title">FashionablyLate</h1>

        {{-- ログアウトボタン (Fortifyのログアウトルートは POST /logout です) --}}
        <form method="POST" action="/logout" class="header__logout">
            @csrf
            <button type="submit" class="logout-button">ログアウト</button>
        </form>
    </header>


    <main>
        <div class="container">
            <h2>Admin</h2>

            {{-- =================================== --}}
            {{-- 1. 検索・絞り込みエリア --}}
            {{-- =================================== --}}
            <div class="search-panel">
                {{-- GETメソッドで検索を実行。リセットボタンもこのフォームの一部として扱う --}}
                <form method="GET" action="/admin" class="search-form">

                    <div class="search-form__group">
                        {{-- キーワード検索 (お名前/メールアドレス) --}}
                        <input type="text" name="keyword" id="keyword" class="search-input" value="{{ request('keyword') }}">
                    </div>
                    
                    <div class="search-form__group">
                        {{-- 性別絞り込み --}}
                        <select class="search-form__select" name="gender" >
                            <option value="">性別</option>
                            <option value="1" {{ (int)request('gender') === 1 ? 'selected' : '' }}>男性</option>
                            <option value="2" {{ (int)request('gender') === 2 ? 'selected' : '' }}>女性</option>
                            {{-- その他（3）はデータに存在しない可能性を考慮し、もしあれば追加 --}}
                            <option value="3" {{ (int)request('gender') === 3 ? 'selected' : '' }}>その他</option> 
                        </select>
                    </div>

                    <div class="search-form__group">
                        {{-- お問い合わせの種類絞り込み --}}
                        <select class="search-form__select" name="content" >
                            <option value="">お問い合わせの種類</option>
                            <option value="商品のお届けについて"{{ request('content') === '商品のお届けについて' ? 'selected' : '' }}>商品のお届けについて</option>
                            <option value="商品の交換について"{{ request('content') === '商品の交換について' ? 'selected' : '' }}>商品の交換について</option>
                            <option value="商品トラブル"{{ request('content') === '商品トラブル' ? 'selected' : '' }}>商品トラブル</option>
                            <option value="ショップへのお問い合わせ"{{ request('content') === 'ショップへのお問い合わせ' ? 'selected' : '' }}>ショップへのお問い合わせ</option>
                            <option value="その他"{{ request('content') === 'その他' ? 'selected' : '' }}>その他</option>
                            
                        </select>
                    </div>

                    <div class="search-form__group search-form__date-range">
                       
                        {{-- 日付範囲検索  --}}
                        <input type="date" name="date_end" class="search-input--date" value="{{ request('date_end') }}">
                    </div>

                    <div class="search-form__actions search-form__group">
                        {{-- 検索ボタン --}}
                        <button class="search-button" type="submit">検索</button>
                        
                        {{-- リセットボタン (クエリパラメータをクリアして同じページにGETリクエスト) --}}
                        <a href="/admin" class="reset-button search-form__group">リセット</a>
                    </div>
                </form>
            </div>
             {{-- =================================== --}}
             {{-- 2. 検索結果一覧とページネーション --}}
             {{-- =================================== --}}
            <div class="pagination-area"> 
               
                    
                    <button id="export-csv-button" class="export-button" >
                    エクスポート
                    </button>
               
                {{ $contacts->links() }} 
            </div>
            
        
            
            <table class="contact-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>お名前</th>
                        <th>性別</th>
                        <th>メールアドレス</th>
                        <th>お問い合わせの種類</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($contacts as $contact)
                        <tr>
                            <td>{{ $contact->id }}</td>
                            <td>{{ $contact->last_name }} {{ $contact->first_name }}</td>
                            <td>
                                @if ($contact->gender === 1) 男性
                                @elseif ($contact->gender === 2) 女性
                                @else その他
                                @endif
                            </td>
                            <td>{{ $contact->email }}</td>
                            {{-- category リレーションの content を表示 --}}
                            <td>{{ $contact->category->content ?? '不明' }}</td>
                            <td>
                                {{-- 詳細ボタン（モーダルトリガー） --}}
                                <label for="modal-toggle-{{ $contact->id }}" class="detail-button">詳細</label>
                            </td>
                           
                        </tr>
                    @endforeach
                </tbody>
            </table>

            
            {{-- =================================== --}}
            {{-- 3. モーダルウィンドウ --}}
            {{-- =================================== --}}

            @foreach ($contacts as $contact)
                {{-- ★トリックの核：非表示のチェックボックス --}}
                <input type="checkbox" id="modal-toggle-{{ $contact->id }}" class="modal-toggle">

                <div class="modal-overlay">
                    <div class="modal-content">
                        {{-- 閉じるボタン（チェックボックスをOFFにするラベル） --}}
                        <label for="modal-toggle-{{ $contact->id }}" class="modal-close">×</label>

                        <h3 class="modal-title">詳細情報 (ID: {{ $contact->id }})</h3>
                        <table class="modal-detail-table">
                            <tr><th>ID</th><td>{{ $contact->id }}</td></tr>
                            <tr><th>お名前</th><td>{{ $contact->last_name }} {{ $contact->first_name }}</td></tr>
                            <tr>
                                <th>性別</th>
                                <td>
                                    @if ($contact->gender === 1) 男性
                                    @elseif ($contact->gender === 2) 女性
                                    @else その他
                                    @endif
                                </td>
                            </tr>
                            <tr><th>メールアドレス</th><td>{{ $contact->email }}</td></tr>
                            <tr><th>電話番号</th><td>{{ $contact->tel }}</td></tr>
                            <tr><th>住所</th><td>{{ $contact->address }}</td></tr>
                            <tr><th>建物名</th><td>{{ $contact->building }}</td></tr>
                            <tr><th>お問い合わせの種類</th><td>{{ $contact->category->content ?? '不明' }}</td></tr>
                            {{-- お問い合わせ内容が長文の場合を考慮し、改行やスペースを保持して表示するCSSクラスを適用 --}}
                            <tr><th>お問い合わせ内容</th><td class="modal-detail-text">{{ $contact->detail }}</td></tr> 
                             {{-- 削除ボタン --}}
                               <td> <form action="/admin/delete" method="POST" class="delete-form" onsubmit="return confirm('本当に削除しますか？');">
                                    @csrf
                                    {{-- DELETEメソッドは利用していないため POST で実装 --}}
                                    {{-- @method('DELETE') --}}
                                    <input type="hidden" name="id" value="{{ $contact->id }}">
                                    <button type="submit" class="delete-button">削除</button>
                                </form>
                                </td>
                        </table>
                    </div>
                    {{-- モーダルの外側をクリックで閉じれるように、オーバーレイ全体を閉じるラベルにする --}}
                    <label for="modal-toggle-{{ $contact->id }}" class="modal-overlay-close"></label>
                </div>
            @endforeach
        </div>
    </main>

</body>
</html>