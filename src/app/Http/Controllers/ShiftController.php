<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User_shift;

class ShiftController extends Controller
{
    public function index()
    {

        // 全てのユーザーのシフトデータを取得
        $shiftData = User_shift::all();

        // レスポンスとしてデータをJSON形式で返す
        return response()->json($shiftData, 200);

    }
}
