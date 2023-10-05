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
        'name' => '中田',
        'email' => 'example1@gmail.com',
        'password' => '12345678',
        ];
        DB::table('admins')->insert($param);

        $param = [
        'name' => '田中',
        'email' => 'example2@gmail.com',
        'password' => '09876543',
        ];
        DB::table('admins')->insert($param);
      }
    
}

