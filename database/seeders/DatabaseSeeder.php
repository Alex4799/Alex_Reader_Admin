<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
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
            'name'=>'Admin',
            'email'=>'admin@gmail.com',
            'gender'=>'male',
            'role'=>'admin',
            'password'=>Hash::make('admin0912')
         ]);

         User::create([
            'name'=>'User',
            'email'=>'user@gmail.com',
            'gender'=>'male',
            'role'=>'user',
            'password'=>Hash::make('user0912')
         ]);
    }
}
