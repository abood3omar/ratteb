<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder 
{
    public function run(): void
    {
        DB::table('users')->insert([
            [
                'name' => 'admin',
                'email' => 'admin@gmail.com',
                'email_verified_at' => null,
                'password' => Hash::make('123456789'),
                'remember_token' => null,
                'MobileNumber' => '0780071050',
                'RoleID' => DB::table('roles')->where('RoleName', 'admin')->first()->RoleID,
                'display_order' => 1,
                'created_at' => now(),
            ],
            [
                'name' => 'user',
                'email' => 'user@gmail.com',
                'email_verified_at' => null,
                'password' => Hash::make('123456789'),
                'remember_token' => null,
                'MobileNumber' => '0700000000',
                'RoleID' => DB::table('roles')->where('RoleName', 'user')->first()->RoleID,
                'display_order' => null,
                'created_at' => now(),
            ],
        ]);
    }
}