<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FashionablyLate | Admin Login</title>
    
    <link rel="stylesheet" href="{{ asset('css/sanitize.css') }}">
    <link rel="stylesheet" href="{{ asset('css/admin_login.css') }}">
</head>
<body>
    
    
    <header class="header">
        <h1 class="header__title">FashionablyLate</h1>
        
        
        <nav class="header__nav">
            
            <a href="/register" class="header__link">Register</a>
        </nav>
        
    </header>

    
    <main>
        <div class="login-form__content">
  <div class="login-form__heading">
    <h2>Login</h2>
  </div>
  <form class="form" method="POST" action="/admin">
       
    <div class="form__group">
      <div class="form__group-title">
        <span class="form__label--item">メールアドレス</span>
      </div>
      <div class="form__group-content">
        <div class="form__input--text">
          <input type="email" name="email" value="{{ old('email') }}" />
        </div>
        <div class="form__error">
          @error('email')
          {{ $message }}
          @enderror
        </div>
      </div>
    </div>
    <div class="form__group">
      <div class="form__group-title">
        <span class="form__label--item">パスワード</span>
      </div>
      <div class="form__group-content">
        <div class="form__input--text">
          <input type="password" name="password" />
        </div>
        <div class="form__error">
          @error('password')
          {{ $message }}
          @enderror
        </div>
      </div>
    </div>
    <div class="form__button">
      <button class="form__button-submit" type="submit">ログイン</button>
    </div>
  </form>
  <div class="register__link">
    <a class="register__button-submit" href="/register">会員登録の方はこちら</a>
  </div>
</div>
    </main>

</body>
</html>