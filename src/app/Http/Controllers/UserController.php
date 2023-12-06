<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {

        // カウンセラーのデータを取得
        $data = User::all();

        // レスポンスとしてデータをJSON形式で返す
        return response()->json($data, 200);

    }

    public function show($id)
    {
        // 特定の管理者のデータを取得
        $user = User::find($id);

        // レスポンスとしてデータをJSON形式で返す
        return response()->json($user, 200);
    }

    public function destroy($id)
    {
        $user = User::find($id);

        if (!$user) {
            return response()->json(['message' => 'カウンセラーが見つかりません'], 404);
        }

        $user->delete();

        return response()->json(['message' => 'カウンセラーが削除されました'], 200);
    }
}
