<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class AdminAuthController extends Controller
{
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:admins',
            'password' => 'required|string|min:8',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 422);
        }

        Admin::create([
            "name" => $request->name,
            "email" => $request->email,
            "password" => Hash::make($request->password),
        ]);

        return response()->json(['message' => 'Successfully admin created']);
    }

    public function login(Request $request)
    {
       $credentials = $request->only('email', 'password');

        if (! $token = auth('admin')->attempt($credentials)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        return $this->respondWithToken($token, auth('admin')->user());
    }

    public function logout()
    {
        auth('admin')->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }

    public function refresh()
    {
        $token = auth('admin')->refresh();
        $admin = auth('admin')->user();

        return $this->respondWithToken($token, $admin);
    }

    protected function generateApiToken()
    {
        $apiToken = Str::random(60);
        auth('admin')->user()->api_token = $apiToken;
        auth('admin')->user()->save();
        return $apiToken;
    }

    protected function respondWithToken($token, $admin)
    {
        return response()->json([
        'access_token' => $token,
        'token_type' => 'bearer',
        'expires_in' => auth()->factory()->getTTL() * 60,
        'admin' => $admin,
        ]);
    }

    public function me()
    {
        return response()->json(auth('admin')->user());
    }
}