<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Auth\UserAuthController;
use App\Http\Controllers\Auth\AdminAuthController;
use App\Http\Controllers\GuestController;
use App\Http\Controllers\ShiftController;
use App\Http\Controllers\UserShiftController;


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// admin用の認証ルート
Route::group([
    'middleware' => ['auth:admin'], // admin用の認証ミドルウェアを指定
    'prefix' => 'admin' // ルートプレフィックスを指定
], function ($router) {
    Route::post('register', [AdminAuthController::class, 'register'])->withoutMiddleware(['auth:admin']);
    Route::post('login', [AdminAuthController::class, 'login'])->withoutMiddleware(['auth:admin']);
    Route::post('logout', [AdminAuthController::class, 'logout']);
    Route::post('refresh', [AdminAuthController::class, 'refresh']);
    Route::get('user', [AdminAuthController::class, 'me']);
});

// user用の認証ルート
Route::group([
    'middleware' => ['auth:api'], // user用の認証ミドルウェアを指定
    'prefix' => 'user'
], function ($router) {
    Route::post('register', [UserAuthController::class, 'register'])->withoutMiddleware(['auth:api']);
    Route::post('login', [UserAuthController::class, 'login'])->withoutMiddleware(['auth:api']);
    Route::post('logout', [UserAuthController::class, 'logout']);
    Route::post('refresh', [UserAuthController::class, 'refresh']);
    Route::get('user', [UserAuthController::class, 'me']);
});

// お客さんのデータを取得
Route::apiResource('guest', GuestController::class);

// 全てのカウンセラーのシフトを取得
Route::apiResource('all_shifts', ShiftController::class);

// カウンセラーのシフト登録、変更、削除
Route::apiResource('user_shift', UserShiftController::class);