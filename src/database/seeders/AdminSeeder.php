<?php

namespace Database\Seeders;

use App\Models\Admin;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;


class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $param = [
        'name' => '管理者',
        'email' => 'example@gmail.com',
        'password' => Hash::make('1234abcd'),
        ];
        DB::table('admins')->insert($param);

    }
    
}

