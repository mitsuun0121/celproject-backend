<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User_shift;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class UserShiftController extends Controller
{
    public function index()
    {
        // ログインユーザーのIDを取得
        $user_id = Auth::id();

        // ログインユーザーに関連するシフトデータを取得
        $shiftData = User_shift::where('user_id', $user_id)->get();

        // レスポンスとしてデータをJSON形式で返す
        return response()->json($shiftData, 200);
    }

    public function store(Request $request)
    {
        // ログインユーザーのIDを取得
        $user_id = Auth::id();

        $data = $request->all();

        // データ型をキャストしてCarbon日付と時刻に変換
        $data['shift_date'] = \Carbon\Carbon::parse($data['shift_date']);
        $data['start_time'] = \Carbon\Carbon::parse($data['start_time']);
        $data['end_time'] = \Carbon\Carbon::parse($data['end_time']);

        // ログインユーザーのIDをデータに追加
        $data['user_id'] = $user_id;
        // User_shift モデルを使ってデータベースに新しいレコードを作成
        $shift = User_shift::create($data);

        // レスポンスとして新しいデータをJSON形式で返す
        return response()->json($shift, 201);
    }

    public function show(Request $request, User_shift $shift)
    {
        
        $shift = User_shift::find($shift->id);
        if ($shift) {
            return response()->json([
              'message' => 'found',
            ], 200);
        } else {
            return response()->json([
              'message' => 'Not found',
            ], 404);
        }
    }


    public function update(Request $request, $id)
    {
    
        // リクエストからデータを取得
        $shiftData = [
            'shift_date' => $request->input('date'),
            'start_time' => $request->input('startTime'),
            'end_time' => $request->input('endTime'),
        ];

            // データを更新
            $shift = User_shift::find($id);

            if (!$shift) {
                return response()->json(['message' => 'シフトが見つかりません'], 404);
            }

            $shift->update($shiftData);

            return response()->json($shift, 200);
    }

    public function destroy($id)
    {
        $shift = User_shift::find($id);

        if (!$shift) {
            return response()->json(['message' => 'シフトが見つかりません'], 404);
        }

        // シフトの削除
        $shift->delete();

        return response()->json(['message' => 'シフトが削除されました'], 200);
    }
}
