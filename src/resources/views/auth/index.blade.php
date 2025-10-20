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
        <form method="POST" action="/logout" class="header__logout" method="post">
            @csrf
            <button type="submit" class="logout-button">ログアウト</button>
        </form>
    </header>

    
    <main>
        <div class="container">
            <h2>Confirm</h2>
    
    
        </div>
    </main>
    
</body>
</html>