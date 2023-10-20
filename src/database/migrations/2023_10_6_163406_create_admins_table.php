<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAdminsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('admins', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable()->default(null); // unsignedBigInteger型を使用
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade'); // 'users' テーブルの 'id' 列を参照
            $table->unsignedBigInteger('user_shift_id')->nullable()->default(null); // unsignedBigInteger型を使用
            $table->foreign('user_shift_id')->references('id')->on('user_shifts')->onDelete('cascade'); // 'user_shifts' テーブルの 'id' 列を参照
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
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
        Schema::dropIfExists('admins');
    }
}
