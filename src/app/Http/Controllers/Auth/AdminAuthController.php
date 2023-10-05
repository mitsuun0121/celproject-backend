<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Support\Facades\Auth;
use Validator;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Exceptions\HttpResponseException;

class AdminAuthController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin', ['except' => ['login','refresh']]);
    }

    public function login(Request $request)
    {
         $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|string|min:6',
        ]);
 
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
 
        if (!$token = auth('admins')->attempt($validator->validated())) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
 
        
        return $this->createNewToken($token);
    }

    public function logout()
    {
        auth()->logout();
        return response()->json(['message' => 'Admin Successfully logged out']);
    }

    public function refresh()
    {
        return $this->respondWithToken(auth('admins')->refresh());
    }

    public function me()
        {$user = Admin::find(Auth::id());
        $user->links = json_decode( $user->links, 1 );
        return response()->json($user);
    }


    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth('admins')->factory()->getTTL() * 60
        ]);
    }

    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'max:16'],
        ]);
    }

    public function register(Request $request)
    {
        // バリデーションルールを定義
        $validator = $this->validator($request->all());

        // バリデーションエラーがある場合、エラーメッセージを返す
        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        // userモデルを作成してデータベースに保存
        User::create([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'password' => Hash::make($request->password)
        ]);

        // 登録成功のメッセージを返す
        return response()->json(['message' => 'Admin registered successfully']);
    }
}
