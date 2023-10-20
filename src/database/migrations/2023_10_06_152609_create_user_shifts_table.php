<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserShiftsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_shifts', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable()->default(null); // unsignedBigInteger型を使用
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade'); // 'users' テーブルの 'id' 列を参照
            $table->unsignedBigInteger('guest_id')->nullable()->default(null); // unsignedBigInteger型を使用
            $table->foreign('guest_id')->references('id')->on('guests')->onDelete('cascade'); // 'users' テーブルの 'id' 列を参照
            $table->date('shift_date')->nullable();
            $table->time('start_time')->nullable();
            $table->time('end_time')->nullable();
            $table->timestamp('created_at')->useCurrent()->nullable();
            $table->timestamp('updated_at')->useCurrent()->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_shifts');
    }
}
