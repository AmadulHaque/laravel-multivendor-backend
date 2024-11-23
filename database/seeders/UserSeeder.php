<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\Merchant;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        User::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $user =User::create( [
            'name' => 'Super admin',
            'phone' => '01712345678',
            'email' => 'admin@test.com',
            'password' => Hash::make('12345678'),
            'role' => User::$ROLE_MERCHANT
        ]);


        Merchant::create([
            'user_id' => $user->id,
            'name' => 'Super admin',
            'phone' => '01712345678',
            'shop_address' => 'Dhaka',
            'shop_name' => 'Super admin',
            'shop_url' => 'admin@test.com',
        ]);



    }
}
