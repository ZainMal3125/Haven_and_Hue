<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            CategorySeeder::class,
        ]);

        // Seed default Admin
        User::firstOrCreate(
            ['email' => 'zain_admin@gmail.com'],
            [
                'name' => 'Zain Admin',
                'password' => \Illuminate\Support\Facades\Hash::make('password123'),
                'role' => 'admin',
                'email_verified_at' => now(),
            ]
        );

        // Seed default Seller
        User::firstOrCreate(
            ['email' => 'zain_seller@gmail.com'],
            [
                'name' => 'Zain Seller',
                'password' => \Illuminate\Support\Facades\Hash::make('password123'),
                'role' => 'seller',
                'email_verified_at' => now(),
            ]
        );

        // Seed default Buyer
        User::firstOrCreate(
            ['email' => 'zain_buyer@gmail.com'],
            [
                'name' => 'Zain Buyer',
                'password' => \Illuminate\Support\Facades\Hash::make('password123'),
                'role' => 'buyer',
                'email_verified_at' => now(),
            ]
        );
    }

}
