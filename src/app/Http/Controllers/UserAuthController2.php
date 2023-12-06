<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Facades\JWTAuth;

class UserAuthController extends Controller
{

    public function register(Request $request)
    {
        User::create([
        "name" => $request->name,
        "email" => $request->email,
        "gender" => $request->gender,
        "password" => Hash::make($request->password)
    ]);

        return response()->json(['message' => 'Successfully user create']);
    }

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);

        // バリデーションに失敗した場合
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 422);
        }

        // 認証を試みる
        if (!$token = JWTAuth::attempt($validator->validated())) {
            
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        return $this->respondWithToken($token, auth('user')->user());
        
    }

    public function logout()
    {
        try {
            // ユーザーのトークンを取得
            $token = JWTAuth::getToken();

            if ($token) {
                // トークンを無効化
                JWTAuth::invalidate($token);
            }

            auth('user')->logout();

            return response()->json(['message' => 'Successfully logged out']);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Logout failed'], 500);
        }
    }

    public function refresh()
    {
        return $this->respondWithToken(auth('user')->refresh());
    }

    protected function generateApiToken()
    {
        $apiToken = Str::random(60);
        auth('user')->user()->api_token = $apiToken;
        auth('user')->user()->save();
        return $apiToken;
    }

    protected function respondWithToken($token, $user)
    {
        return response()->json([
        'access_token' => $token,
        'token_type' => 'bearer',
        'expires_in' => auth()->factory()->getTTL() * 60,
        'user' => $user,
        ]);
    }

    public function me()
    {
        return response()->json(auth('user')->user());
    }
    

}
    
