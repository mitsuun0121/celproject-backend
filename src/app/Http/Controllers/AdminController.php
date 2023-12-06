<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Admin;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    public function index()
    {

        // 管理者のデータを取得
        $data = Admin::all();

        // レスポンスとしてデータをJSON形式で返す
        return response()->json($data, 200);

    }

    public function show($id)
    {
        // 特定の管理者のデータを取得
        $admin = Admin::find($id);

        // レスポンスとしてデータをJSON形式で返す
        return response()->json($admin, 200);
    }
}
