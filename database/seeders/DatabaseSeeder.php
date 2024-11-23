<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([

            SellTypeSeeder::class,
            ProductTypeSeeder::class,
            AccountTypeSeeder::class,
            CustomerTypeSeeder::class,
            UserSeeder::class,
            CategorySeeder::class,
        ]);
    }
}
