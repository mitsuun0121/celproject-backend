{{ $guest->name }} 様<br><br>
本日の無料カウンセリングのお知らせです。<br><br>

予約詳細:<br>
日付: {{ \Illuminate\Support\Carbon::parse($guest->date)->format('Y年m月d日') }}<br>
時間: {{ \Illuminate\Support\Carbon::parse($guest->timeSlot)->format('H時') }}<br><br>

以下のリンクからZoomに接続をお願いいたします。<br><br>

https:// <br><br>

URLをクリックすると自動でアプリが立ち上がりますので、ミーティングIDとパスコードを入力してご入室下さい。<br><br>

ミーティングID: <br>

パスコード: <br><br>

開始10分前から接続可能な状態にしておきますので、<br>
接続環境が心配な場合はお早めに接続をお願いいたします。<br><br>

何かご質問があればお気軽にお知らせください。<br><br>

本日はよろしくお願いいたします。