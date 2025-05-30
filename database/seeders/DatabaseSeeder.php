<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::create([
            'name' => 'Yapi',
            'email' => 'theodoreyapi@gmail.com',
            'phone' => '0585831647',
            'type' => 'super',
            'last_name' => 'Théodore',
            'status' => 'Active',
            'password' => hash::make(1234567890),
        ]);
    }
}
