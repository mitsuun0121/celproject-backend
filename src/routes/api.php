<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Auth\UserAuthController;
use App\Http\Controllers\Auth\AdminAuthController;

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
/*Route::group([
    'middleware' => ['auth:admin'], // admin用の認証ミドルウェアを指定
    'prefix' => 'auth' // ルートプレフィックスを指定
], function ($router) {
    Route::post('register', [AdminAuthController::class, 'register']);
    Route::post('login', [AdminAuthController::class, 'login']);
    Route::post('logout', [AdminAuthController::class, 'logout']);
    Route::post('refresh', [AdminAuthController::class, 'refresh']);
    Route::get('profile', [AdminAuthController::class, 'profile']);
    // その他のユーザー向けルートをここに追加
});*/


// user用の認証ルート
Route::group([
    'middleware' => ['auth:api'], // user用の認証ミドルウェアを指定
    'prefix' => 'auth'
], function ($router) {
    Route::post('register', [UserAuthController::class, 'register'])->withoutMiddleware(['auth:api']);
    Route::post('login', [UserAuthController::class, 'login'])->withoutMiddleware(['auth:api']);
    Route::post('logout', [UserAuthController::class, 'logout']);
    Route::post('refresh', [UserAuthController::class, 'refresh']);
    Route::get('user', [UserAuthController::class, 'me']);
});


