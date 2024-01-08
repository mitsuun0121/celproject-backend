<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Guest;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use App\Jobs\SendReservationEmail;
use App\Jobs\SendCounselingEmail;

class GuestController extends Controller
{

    public function index()
    {
        // 顧客のデータを取得
        $data = Guest::all();

        // レスポンスとしてデータをJSON形式で返す
        return response()->json($data, 200);
    }

    public function store(Request $request)
    {
        // フォームから送信されたデータを取得
        $data = $request->all();

        // '男性' を 1、'女性' を 2、無回答を 3 に変換
        if ($data['gender'] === '男性') {
            $data['gender'] = 1;
        } elseif ($data['gender'] === '女性') {
            $data['gender'] = 2;
        } else {
            $data['gender'] = 3;
        }

        // データベースに保存
        $guest = Guest::create($data);

        // メール送信ジョブをディスパッチ
        dispatch(new SendReservationEmail($guest->id, $guest->email, $guest->name, $guest->date, $guest->timeSlot));

        // 予約に紐づいたuser_idを取得
        $userId = $guest->user_id;

        // 担当者のIDを取得
        $user = User::find($userId);

        if ($user) {
            // メール送信ジョブをディスパッチ
            dispatch(new SendCounselingEmail($guest->id, $user->id, $guest->date, $guest->timeSlot));
        }

        // 保存後の処理やレスポンスを返す
        return response()->json(['message' => 'データが保存されて、メールが送信されました。']);

    }
    
    public function destroy($id)
    {
        $guest = Guest::find($id);

        if (!$guest) {
            return response()->json(['message' => '予約データが見つかりません'], 404);
        }

        $guest->delete();

        return response()->json(['message' => '予約データが削除されました'], 200);
    }
}
