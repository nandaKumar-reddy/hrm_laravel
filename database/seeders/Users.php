<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User; // Import the User model
use Illuminate\Support\Facades\Hash; // Import the Hash facade

class Users extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name'     => 'Nanda Reddy',
            'email'    => 'nandareddy.r1995@gmail.com',
            'password' => Hash::make('password'), // Hash the password using Bcrypt
        ]);
    }
}
