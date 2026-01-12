<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EntityActionSeeder extends Seeder
{
    public function run(): void
    {
        // DB::table('entityactions')->insert([
         // account entity
        //     ['EntityID' => DB::table('entities')->where('EntityName', 'account')->first()->EntityID, 'ActionID' => DB::table('actions')->where('ActionName', 'show')->first()->ActionID],
        //     ['EntityID' => DB::table('entities')->where('EntityName', 'account')->first()->EntityID, 'ActionID' => DB::table('actions')->where('ActionName', 'edit')->first()->ActionID],
        //     ['EntityID' => DB::table('entities')->where('EntityName', 'account')->first()->EntityID, 'ActionID' => DB::table('actions')->where('ActionName', 'delete')->first()->ActionID],

        //     // system-module entity
        //     ['EntityID' => DB::table('entities')->where('EntityName', 'system-module')->first()->EntityID, 'ActionID' => DB::table('actions')->where('ActionName', 'show')->first()->ActionID],
        //     // role-rights entity
        //     ['EntityID' => DB::table('entities')->where('EntityName', 'role-rights')->first()->EntityID, 'ActionID' => DB::table('actions')->where('ActionName', 'show')->first()->ActionID],
        //     // users entity
        //     ['EntityID' => DB::table('entities')->where('EntityName', 'users')->first()->EntityID, 'ActionID' => DB::table('actions')->where('ActionName', 'show')->first()->ActionID],
        //     ['EntityID' => DB::table('entities')->where('EntityName', 'users')->first()->EntityID, 'ActionID' => DB::table('actions')->where('ActionName', 'approve')->first()->ActionID],
        //     ['EntityID' => DB::table('entities')->where('EntityName', 'users')->first()->EntityID, 'ActionID' => DB::table('actions')->where('ActionName', 'reject')->first()->ActionID],
        //     // sessions entity
        //     ['EntityID' => DB::table('entities')->where('EntityName', 'sessions')->first()->EntityID, 'ActionID' => DB::table('actions')->where('ActionName', 'show')->first()->ActionID],
        //     // security entity
        //     ['EntityID' => DB::table('entities')->where('EntityName', 'security')->first()->EntityID, 'ActionID' => DB::table('actions')->where('ActionName', 'show')->first()->ActionID],
        // ]);
    }
}