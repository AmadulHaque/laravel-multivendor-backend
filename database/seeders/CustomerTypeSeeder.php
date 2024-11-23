<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CustomerTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        \App\Models\CustomerType::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        \App\Models\CustomerType::create([
            'name' => 'B2B',

        ]);
    }
}
