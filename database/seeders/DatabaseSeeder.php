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
        \App\Models\User::factory()->create([
            'name' => 'Ahmed Nagi',
            'email' => 'ahmedflnagi@gmail.com',
            'phone' => '01122061032',
            'password' => bcrypt('@Osama123'),
        ]);
    }
}
