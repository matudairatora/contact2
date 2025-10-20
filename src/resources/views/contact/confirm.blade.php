@extends('layouts.app')

{{-- 確認画面専用のCSSを読み込む --}}
@section('css')
<link rel="stylesheet" href="{{ asset('css/contact_confirm.css') }}">
@endsection

@section('content')
<div class="container">
    <h2>Confirm</h2>
    
    <form method="post" action="/thanks"> 
        @csrf
        
        {{-- 全てのデータを hidden フィールドとして保持 --}}
        @foreach ($data as $key => $value)
            @if (!in_array($key, ['tel_part1', 'tel_part2', 'tel_part3']))
                <input type="hidden" name="{{ $key }}" value="{{ $value }}">
            @endif
        @endforeach

        {{-- ★ここから <table> を使用 --}}
        <table class="confirm-table">
            
            {{-- 1. お名前 --}}
            <tr>
                <th class="confirm-label">お名前</th>
                <td class="confirm-value onamae">{{ $data['last_name'] }}
                <div class="spece"></div> {{ $data['first_name'] }}</td>
            </tr>
            
            {{-- 2. 性別 --}}
            <tr>
                <th class="confirm-label">性別</th>
                <td class="confirm-value">
                {{ $data['gender_text'] }}
                </td>
            </tr>

            {{-- 3. メールアドレス --}}
            <tr>
                <th class="confirm-label">メールアドレス</th>
                <td class="confirm-value">{{ $data['email'] }}</td>
            </tr>

            {{-- 4. 電話番号 --}}
            <tr>
                <th class="confirm-label">電話番号</th>
                <td class="confirm-value">{{ $data['tel'] }}</td>
            </tr>

            {{-- 5. 住所 --}}
            <tr>
                <th class="confirm-label">住所</th>
                <td class="confirm-value">{{ $data['address'] }}</td>
            </tr>

            {{-- 6. 建物名 --}}
            <tr>
                <th class="confirm-label">建物名</th>
                <td class="confirm-value">{{ $data['building'] }}</td>
            </tr>

            {{-- 7. お問い合わせの種類 --}}
            <tr>
                <th class="confirm-label">お問い合わせの種類</th>
                <td class="confirm-value category_id">
                   {{ $data['content'] }}
                </td>
            </tr>

            {{-- 8. お問い合わせ内容 --}}
            <tr>
                <th class="confirm-label">お問い合わせ内容</th>
                <td class="confirm-value">{{ $data['detail'] }}</td>
            </tr>

        </table>
        {{-- ★<table> ここまで --}}

        <div class="form__button--confirm">
            <button type="submit" class="submit-button">送信</button>
            <button type="button" class="back-button" onclick="history.back()">修正</button>
        </div>

    </form>
</div>
@endsection