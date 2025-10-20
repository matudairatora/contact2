@extends('layouts.app')

@section('css')

<link rel="stylesheet" href="{{ asset('css/contact_index.css') }}">
@endsection

@section('content')
<div class="container">
    {{-- エラー表示 --}}
        <div>
            @if ($errors->any())
            <div class="todo__alert--danger">
            <ul>
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
            </ul>
            </div>
            @endif
        </div>
    <h2>Contact</h2>
    

    <form method="post" action="/confirm"> 
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
                <input type="text" name="last_name" placeholder="例: 山田" value="{{ old('last_name') }}" >
                <div class=spece> </div>
                <input type="text" name="first_name" placeholder="例: 太郎" value="{{ old('first_name') }}" >
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
            <div class="form__input form__input--radio" value="{{ old('gender') }}">
                {{-- 画像に合わせてラジオボタンの並び順と初期選択を設定 --}}
                <label><input type="radio" name="gender" value="1">男性</label>
                <label><input type="radio" name="gender" value="2">女性</label>
                <label><input type="radio" name="gender" value="3">その他</label>
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
                <input type="email" name="email" placeholder="例: test@example.com" value="{{ old('email') }}" >
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
                <input type="text" name="tel_part1" placeholder="080" value="{{ old('tel_part1') }}">
                <div class=spece> </div>
                 -
                <div class=spece> </div>
                <input type="text" name="tel_part2" placeholder="1234" value="{{ old('tel_part2') }}">
                <div class=spece> </div>
                 -
                 <div class=spece> </div>
                <input type="text" name="tel_part3" placeholder="5678" value="{{ old('tel_part3') }}">
               
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
                <input type="text" name="address" placeholder="例: 東京都渋谷区千駄ヶ谷1-2-3" value="{{ old('address') }}">
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
                <input type="text" name="building" placeholder="例: 千駄ヶ谷マンション101" value="{{ old('building') }}">
            </div>
            </td>
        
        </tr> 
        
        

        {{-- 7. お問い合わせの種類 (content) --}}
        <tr> 
        
            <th class="confirm-label">
                <label class="form__label">お問い合わせの種類 <span class="required">※</span></label>
            </th>
            <td class="confirm-value">
            <div class="form__input">
                <select name="content" value="{{ old('content') }}" >
                    <option value="" disabled selected>選択してください</option>
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
                <textarea name="detail" rows="5" placeholder="お問い合わせ内容をご記載ください" value="{{ old('detail') }}"></textarea>
            </div>
            </td>
        
        </tr>
        {{-- エラー表示 --}}
        
        
        </table>
        
        </div>
            <div class="form__button">
            <button type="submit">確認画面</button>
        </div>
    
    </form>
</div>
@endsection