<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class PeopleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create Admin Role
        $adminRole = Role::findOrCreate('admin', 'web');

        // Create Admin User
        $admin = User::updateOrCreate(
            ['email' => 'movvoreach@gmail.com'],
            [
                'name' => 'System Administrator',
                'email' => 'movvoreach@gmail.com',
                'password' => Hash::make('password'),
            ]
        );

        // Assign Admin Role
        $admin->assignRole($adminRole);
    }
}