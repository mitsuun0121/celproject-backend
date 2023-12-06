<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGuestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('guests', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('kana');
            $table->string('email')->unique();
            $table->string('phone');
            $table->integer('gender')->default(1);
            $table->string('message');
            $table->date('date');
            $table->time('timeSlot');
            $table->unsignedBigInteger('user_id')->nullable()->default(null); // unsignedBigInteger型を使用
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade'); // 'users' テーブルの 'id' 列を参照
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
        Schema::dropIfExists('guests');
    }
}
