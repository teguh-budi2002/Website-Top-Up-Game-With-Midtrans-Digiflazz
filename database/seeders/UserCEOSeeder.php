<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserCEOSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'role_id' => 1,
            'fullname' => 'Teguh Budi Laksono',
            'username' => 'teguh2002',
            'email' => 'budilaksono1102@gmail.com',
            'password' => 'adminceo123#@!',
            'phone_number' => '083834819552'
        ]);
    }
}
