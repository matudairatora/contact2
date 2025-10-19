<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FashionablyLate | Admin</title>
    
    <link rel="stylesheet" href="{{ asset('css/sanitize.css') }}">
    <link rel="stylesheet" href="{{ asset('css/admin_index.css') }}">
    
</head>
<body>
    
    {{-- ヘッダー領域 --}}
    <header class="header">
        <h1 class="header__title">管理システム</h1>
        
        {{-- ログアウトボタン --}}
        <form method="POST" action="/admin/logout" class="header__logout">
            @csrf
            <button type="submit" class="logout-button">ログアウト</button>
        </form>
    </header>

    
    <main>
        <div class="admin-container">
            <h2>お客様情報</h2>
            
            {{-- =================================== --}}
            {{-- 1. 検索・絞り込みエリア (変更なし) --}}
            {{-- =================================== --}}
            <div class="search-panel">
                <form method="GET" action="/admin" class="search-form">
                    {{-- 検索フォームのグループ... (省略) --}}
                    
                    <div class="search-form__group">
                        <label for="keyword" class="search-label">お名前</label>
                        <input type="text" name="keyword" id="keyword" class="search-input" value="{{ request('keyword') }}">
                    </div>

                    <div class="search-form__group">
                        <label for="gender" class="search-label">性別</label>
                        <select name="gender" id="gender" class="search-select">
                            <option value="" selected>全て</option>
                            <option value="1" @if(request('gender') == '1') selected @endif>男性</option>
                            <option value="2" @if(request('gender') == '2') selected @endif>女性</option>
                            <option value="3" @if(request('gender') == '3') selected @endif>その他</option>
                        </select>
                    </div>

                    <div class="search-form__group">
                        <label for="date" class="search-label">登録日</label>
                        <input type="date" name="date" id="date" class="search-input-date" value="{{ request('date') }}">
                    </div>

                    <div class="search-form__group">
                        <label for="category_id" class="search-label">お問い合わせの種類</label>
                        <select name="category_id" id="category_id" class="search-select">
                            <option value="" selected>全て</option>
                            <option value="1" @if(request('category_id') == '1') selected @endif>商品に関するお問い合わせ</option>
                            <option value="2" @if(request('category_id') == '2') selected @endif>採用に関するお問い合わせ</option>
                            <option value="3" @if(request('category_id') == '3') selected @endif>その他</option>
                        </select>
                    </div>

                    <div class="search-actions">
                        <button type="submit" class="search-button">検索</button>
                        <button type="button" class="reset-button" onclick="window.location.href='/admin'">リセット</button>
                    </div>
                </form>
            </div>


            {{-- =================================== --}}
            {{-- 2. ページネーションと一覧表示エリア (変更なし) --}}
            {{-- =================================== --}}
            
            <div class="table-info">
                <div class="pagination-area">
                    全 **XX** 件中 **1**〜**20** 件
                </div>

                <form action="/admin/export" method="POST" class="export-form">
                    @csrf
                    <button type="submit" class="export-button">エクスポート</button>
                </form>
            </div>

            <div class="results-table-wrapper">
                <table class="results-table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>お名前</th>
                            <th>性別</th>
                            <th>メールアドレス</th>
                            <th>お問い合わせの種類</th>
                            <th></th> {{-- 詳細ボタン用 --}}
                        </tr>
                    </thead>
                    <tbody>
                        {{-- データのループを想定し、IDごとにモーダル要素を配置 --}}
                        @php
                            $forms = [ /* ダミーデータ */
                                ['id' => 1, 'name' => '山田 太郎', 'gender' => '男性', 'email' => 'test@example.com', 'category' => '商品に関するお問い合わせ', 'detail' => '商品のサイズについて詳しく知りたい。', 'address' => '東京都渋谷区'],
                                ['id' => 2, 'name' => '田中 花子', 'gender' => '女性', 'email' => 'hana@example.com', 'category' => 'その他', 'detail' => '領収書の発行をお願いしたいです。', 'address' => '大阪府大阪市'],
                            ];
                        @endphp
                        
                        @foreach ($forms as $form)
                        <tr>
                            <td>{{ $form['id'] }}</td>
                            <td>{{ $form['name'] }}</td>
                            <td>{{ $form['gender'] }}</td>
                            <td>{{ $form['email'] }}</td>
                            <td>{{ $form['category'] }}</td>
                            <td>
                                {{-- ★詳細モーダルを開くためのボタン（ラベル） --}}
                                <label for="modal-toggle-{{ $form['id'] }}" class="detail-button">詳細</label>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            
        </div>
    </main>

    
    {{-- =================================== --}}
    {{-- 3. モーダルウィンドウ (CSS制御用) --}}
    {{-- =================================== --}}
    
    @foreach ($forms as $form)
        {{-- ★トリックの核：非表示のチェックボックス --}}
        <input type="checkbox" id="modal-toggle-{{ $form['id'] }}" class="modal-toggle">
        
        <div class="modal-overlay" for="modal-toggle-{{ $form['id'] }}">
            <div class="modal-content">
                {{-- 閉じるボタン（チェックボックスをOFFにするラベル） --}}
                <label for="modal-toggle-{{ $form['id'] }}" class="modal-close">×</label>
                
                <h3 class="modal-title">詳細情報 (ID: {{ $form['id'] }})</h3>
                <table class="modal-detail-table">
                    <tr><th>ID</th><td>{{ $form['id'] }}</td></tr>
                    <tr><th>お名前</th><td>{{ $form['name'] }}</td></tr>
                    <tr><th>性別</th><td>{{ $form['gender'] }}</td></tr>
                    <tr><th>メールアドレス</th><td>{{ $form['email'] }}</td></tr>
                    <tr><th>住所</th><td>{{ $form['address'] }}</td></tr>
                    <tr><th>お問い合わせの種類</th><td>{{ $form['category'] }}</td></tr>
                    <tr><th>お問い合わせ内容</th><td class="modal-detail-text">{{ $form['detail'] }}</td></tr>
                </table>
            </div>
            {{-- モーダルの外側をクリックで閉じれるように、オーバーレイ全体を閉じるラベルにする --}}
            <label for="modal-toggle-{{ $form['id'] }}" class="modal-background"></label> 
        </div>
    @endforeach
    
</body>
</html>