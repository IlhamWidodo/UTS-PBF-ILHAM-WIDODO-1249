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
        //Data Nama, Email, Password
        User::create([    
            'name' => 'Administrator',
            'email'=> 'admin123@gmail.com',
            'password'=> Hash::make('1234567890')
        ]);
    }
}
