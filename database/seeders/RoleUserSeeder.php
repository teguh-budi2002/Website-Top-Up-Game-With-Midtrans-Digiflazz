<?php

namespace Database\Seeders;

use App\Models\RoleUser;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RoleUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        RoleUser::create([
            'id' => 1,
            'role_name' => 'CEO & Founder',
            'task_role' => 'Owner of company'
        ]);

        RoleUser::create([
            'id' => 2,
            'role_name' => 'Admin',
            'task_role' => 'Manage dashboard'
        ]);

        RoleUser::create([
            'id' => 3,
            'role_name' => 'Member',
            'task_role' => 'Member company'
        ]);

        RoleUser::create([
            'id' => 4,
            'role_name' => 'Writter',
            'task_role' => 'Blogger writter'
        ]);
    }
}
