<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AccountTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        \App\Models\AccountType::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        \App\Models\AccountType::create([
            'name' => 'Asset',

        ]);
        \App\Models\AccountType::create([
            'name' => 'Bank/Cash',
        ]);
        \App\Models\AccountType::create([
            'name' => 'Inventory',
        ]);
        \App\Models\AccountType::create([
            'name' => 'Supplier',
        ]);
        \App\Models\AccountType::create([
            'name' => 'Loan & Libalities',
        ]);
        \App\Models\AccountType::create([
            'name' => 'Income',
        ]);
        \App\Models\AccountType::create([
            'name' => 'Purchase',
        ]);
        \App\Models\AccountType::create([
            'name' => 'Expense',
        ]);
        \App\Models\AccountType::create([
            'name' => 'Equity',
        ]);
    }
}
