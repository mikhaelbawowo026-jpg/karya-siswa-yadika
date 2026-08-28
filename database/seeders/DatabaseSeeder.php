<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Admin SMK Yadika',
            'email' => 'admin@smkyadika.sch.id',
            'password' => Hash::make('admin123'),
        ]);
    }
}