<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EntitySeeder extends Seeder
{
    public function run(): void
    {
        // DB::table('entities')->insert([
    
        //     ['EntityName' => 'account', 'ModuleID' => DB::table('modules')->where('ModuleName', 'User')->first()->ModuleID],
        //     ['EntityName' => 'system-module', 'ModuleID' => DB::table('modules')->where('ModuleName', 'Security')->first()->ModuleID],
        //     ['EntityName' => 'role-rights', 'ModuleID' => DB::table('modules')->where('ModuleName', 'Security')->first()->ModuleID],
        //     ['EntityName' => 'users', 'ModuleID' => DB::table('modules')->where('ModuleName', 'Security')->first()->ModuleID],
        //     ['EntityName' => 'sessions', 'ModuleID' => DB::table('modules')->where('ModuleName', 'Security')->first()->ModuleID],
        //     ['EntityName' => 'security', 'ModuleID' => DB::table('modules')->where('ModuleName', 'Security')->first()->ModuleID],
        // ]);
    }
}