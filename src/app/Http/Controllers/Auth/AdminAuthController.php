<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin;
use Illuminate\Support\Facades\Hash;

class AdminAuthController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin', ['except' => ['login', 'refresh']]);
    }

    public function register(Request $request)
    {
        Admin::create([
        "name" => $request->name,
        "email" => $request->email,
        "password" => Hash::make($request->password)
    ]);

        return response()->json(['message' => 'Successfully admin create']);
    }

    public function login()
    {
        $credentials = request(['email', 'password']);

        if (! $token = auth('admin')->attempt($credentials)) {
        return response()->json(['error' => 'Unauthorized'], 401);
        }

        // 認証に成功したことを確認
        if (auth('admin')->check()) {
            // 管理者が認証に成功したらapi_tokenを生成
            $user = auth('admin')->user();
            $user->api_token = Str::random(60); // 60文字のランダムな文字列を生成
            $user->save();

            return $this->respondWithToken($token);
        } else {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
    }

    public function logout()
    {
        auth()->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }

    public function refresh()
    {
        return $this->respondWithToken(auth()->refresh());
    }

    protected function respondWithToken($token)
    {
        return response()->json([
        'access_token' => $token,
        'token_type' => 'bearer',
        'expires_in' => auth()->factory()->getTTL() * 60
        ]);
    }

    public function me()
    {
        return response()->json(auth()->user());
    }

}
