<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ActionSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('actions')->insert([
            ['ActionName' => 'create'],
            ['ActionName' => 'show'],
            ['ActionName' => 'edit'],
            ['ActionName' => 'delete'],
        ]);
    }
}