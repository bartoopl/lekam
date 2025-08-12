<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create test users
        User::create([
            'name' => 'Jan Kowalski',
            'email' => 'farmaceuta@test.pl',
            'password' => Hash::make('password'),
            'user_type' => 'farmaceuta',
            'phone' => '123456789',
            'pwz_number' => 'PWZ12345',
            'pharmacy_address' => 'ul. Testowa 1, 00-001 Warszawa',
            'pharmacy_postal_code' => '00-001',
            'pharmacy_city' => 'Warszawa',
            'ref' => 'TEST001',
        ]);

        User::create([
            'name' => 'Anna Nowak',
            'email' => 'technik@test.pl',
            'password' => Hash::make('password'),
            'user_type' => 'technik_farmacji',
            'phone' => '987654321',
            'pwz_number' => 'PWZ67890',
            'pharmacy_address' => 'ul. Przykładowa 2, 01-001 Kraków',
            'pharmacy_postal_code' => '01-001',
            'pharmacy_city' => 'Kraków',
            'ref' => 'TEST002',
        ]);
    }
}