{{ $userName }} さん お疲れ様です。<br><br>
{{ \Illuminate\Support\Carbon::parse($guest->date)->format('Y年m月d日') }} {{ \Illuminate\Support\Carbon::parse($guest->timeSlot)->format('H時') }} にカウンセリングの予約が入りました。<br>
予約詳細の確認と対応のほどよろしくお願いします。