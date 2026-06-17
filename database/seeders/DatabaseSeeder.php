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
        User::create([
            'name' => 'Zain Admin',
            'email' => 'zain_admin@gmail.com',
            'password' => \Illuminate\Support\Facades\Hash::make('password123'),
            'role' => 'admin',
            'email_verified_at' => now(),
        ]);

        // Seed default Seller
        User::create([
            'name' => 'Zain Seller',
            'email' => 'zain_seller@gmail.com',
            'password' => \Illuminate\Support\Facades\Hash::make('password123'),
            'role' => 'seller',
            'email_verified_at' => now(),
        ]);

        // Seed default Buyer
        User::create([
            'name' => 'Zain Buyer',
            'email' => 'zain_buyer@gmail.com',
            'password' => \Illuminate\Support\Facades\Hash::make('password123'),
            'role' => 'buyer',
            'email_verified_at' => now(),
        ]);
    }

}
