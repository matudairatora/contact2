<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\ContactController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
// フォーム表示 (GET /)
Route::get('/', [ContactController::class, 'index']);

// 確認画面へ (POST /confirm)
Route::post('/confirm', [ContactController::class, 'confirm']);

// ★データ保存とサンクスページへ遷移 (POST /thanks)
Route::post('/thanks', [ContactController::class, 'send']);

// ★データ保存とサンクスページへ遷移 (POST /thanks)
Route::post('/thanks', [ContactController::class, 'send']);

