<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
class users extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        DB::table('users')->insert([
            [
                'name'              => 'employee',
                'email'             => 'hamde@gmail.com',
                'email_verified_at' => null,
                'password'          => Hash::make('123456789'),
                'remember_token'    => null,
                'created_at'        => null, 
                'updated_at'        => '2025-02-05 21:17:42',
                'role'              => 'employee',
            ],
            [
                'name'              => 'Admin',
                'email'             => 'admin@gmail.com',
                'email_verified_at' => null,
                'password'          => Hash::make('123456789'),
                'remember_token'    => null,
                'created_at'        => null, 
                'updated_at'        => null,
                'role'              => 'admin',
            ],
        ]);
    }
}
