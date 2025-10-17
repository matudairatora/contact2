@extends('layouts.app')

@section('css')

<link rel="stylesheet" href="{{ asset('css/contact_index.css') }}">
@endsection

@section('content')
<div class="container">
    <h2>Contact</h2>
    

    <form method="POST" action="/confirm"> 
        @csrf
         <table class="confirm-table">
        {{-- 1. 氏名 --}}
        <tr> 
        
            <th class="confirm-label">
                <label class="form__label">お名前 <span class="required">※</span></label>
            </th>
            <td class="confirm-value">
            <div class="form__input">
                <div class="form__input--name">
                <input type="text" name="last_name" placeholder="例: 山田" >
                <div class=spece> </div>
                <input type="text" name="first_name" placeholder="例: 太郎" >
                </div>
            </div>
            </td>
        
        </tr>
        
                 

        <tr> 
        {{-- 2. 性別 (gender) --}}
        
            <th class="confirm-label">
                <label class="form__label">性別 <span class="required">※</span></label>
            </th>
            <td class="confirm-value">
            <div class="form__input form__input--radio">
                {{-- 画像に合わせてラジオボタンの並び順と初期選択を設定 --}}
                <label><input type="radio" name="gender" value="1.男性" >男性</label>
                <label><input type="radio" name="gender" value="2.女性">女性</label>
                <label><input type="radio" name="gender" value="3.その他">その他</label>
            </div>
            </td>
        
        </tr> 
        
        


        {{-- 3. メールアドレス (email) --}}
        <tr> 
        
            <th class="confirm-label">    
                <label class="form__label">メールアドレス <span class="required">※</span></label>
            </th>
            <td class="confirm-value">
            <div class="form__input">
                <input type="email" name="email" placeholder="例: test@example.com" required>
            </div>
            </td>
        
        </tr> 

        
        
        {{-- 4. 電話番号 (tel) --}}
        <tr> 
        
            <th class="confirm-label">
                <label class="form__label">電話番号 <span class="required">※</span></label>
            </th>
            <td class="confirm-value">
            <div class="form__input">
                <div class="form__input--tel">
                {{-- 画像のレイアウトに合わせて3つの入力欄を作成。仕様書ではtelは1つのカラム --}}
                <input type="text" name="tel_part1" placeholder="080" >
                <div class=spece> </div>
                 -
                <div class=spece> </div>
                <input type="text" name="tel_part2" placeholder="1234" >
                <div class=spece> </div>
                 -
                 <div class=spece> </div>
                <input type="text" name="tel_part3" placeholder="5678" >
               
                </div>
            </div>
            </td>
        
        </tr> 

        

        {{-- 5. 住所 (address) --}}
        <tr> 
        
            <th class="confirm-label">
                <label class="form__label">住所 <span class="required">※</span></label>
            </th>
            <td class="confirm-value">
            <div class="form__input">
                <input type="text" name="address" placeholder="例: 東京都渋谷区千駄ヶ谷1-2-3" >
            </div>
            </td>
        
        </tr> 

        {{-- 6. 建物名 (building) --}}
        <tr> 
        
            <th class="confirm-label">
                <label class="form__label">建物名</label>
            </th>
            <td class="confirm-value">
            <div class="form__input">
                <input type="text" name="building" placeholder="例: 千駄ヶ谷マンション101">
            </div>
            </td>
        
        </tr> 
        
        

        {{-- 7. お問い合わせの種類 (category_id) --}}
        <tr> 
        
            <th class="confirm-label">
                <label class="form__label">お問い合わせの種類 <span class="required">※</span></label>
            </th>
            <td class="confirm-value">
            <div class="form__input">
                <select name="category_id" >
                    <option value="" disabled selected>選択してください</option>
                    {{-- ここに categories テーブルからのデータが入る予定 --}}
                    <option value="商品のお届けについて">商品のお届けについて</option>
                    <option value="商品の交換について">商品の交換について</option>
                    <option value="商品トラブル">商品トラブル</option>
                    <option value="ショップへのお問い合わせ">ショップへのお問い合わせ</option>
                    <option value="その他">その他</option>
                </select>
            </div>
            </td>
        
        </tr> 

        {{-- 8. お問い合わせ内容 (detail) --}}
        <tr> 
        
            <th class="confirm-label">
                <label class="form__label">お問い合わせ内容 <span class="required">※</span></label>
            </th>
            <td class="confirm-value">
            <div class="form__input">
                <textarea name="detail" rows="5" placeholder="お問い合わせ内容をご記載ください" ></textarea>
            </div>
            </td>
        
        </tr>
        {{-- エラー表示 --}}
        
        @error('last_name') <tr> <div class="error-message">{{ $message }}</div> @enderror
        @error('first_name') <div class="error-message">{{ $message }}</div></tr>  @enderror
        @error('gender') <tr> <div class="error-message">{{ $message }}</div></tr>  @enderror
        @error('email') <tr> <div class="error-message">{{ $message }}</div></tr>  @enderror
        @error('tel') <tr> <div class="error-message">{{ $message }}</div> </tr> @enderror
        @error('address') <tr> <div class="error-message">{{ $message }}</div></tr>  @enderror
        @error('category_id')<tr>  <div class="error-message">{{ $message }}</div></tr>  @enderror
        </table>
        <div class="form__button">
            <button type="submit">確認画面</button>
        </div>

    </form>
</div>
@endsection