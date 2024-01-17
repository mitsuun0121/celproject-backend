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

class UserAuthController extends Controller
{

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'gender' => 'required',
            'password' => 'required|string|min:8',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 422);
        }
        
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
       $credentials = $request->only('email', 'password');

        if (! $token = auth('user')->attempt($credentials)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        return $this->respondWithToken($token, auth('user')->user());
    }

    public function logout()
    {
        auth('user')->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }

    public function refresh()
    {
        $token = auth('user')->refresh();
        $user = auth('user')->user();

        return $this->respondWithToken($token, $user);
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
    
