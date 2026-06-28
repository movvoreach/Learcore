<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        app(PermissionRegistrar::class)->forgetCachedPermissions();

        $permissions = [
            'manage users',
            'manage roles',
            'manage academic structure',
            'manage students',
            'manage courses',
            'manage lessons',
            'manage assessments',
            'manage promotions',
            'view student dashboard',
        ];

        foreach ($permissions as $permission) {
            Permission::findOrCreate($permission, 'web');
        }

        $superAdmin = Role::findOrCreate('super_admin', 'web');
        $admin = Role::findOrCreate('admin', 'web');
        $teacher = Role::findOrCreate('teacher', 'web');
        $student = Role::findOrCreate('student', 'web');

        $allPermissions = Permission::query()->whereIn('name', $permissions)->where('guard_name', 'web')->get();

        $superAdmin->syncPermissions($allPermissions);
        $admin->syncPermissions($allPermissions);
        $teacher->syncPermissions(Permission::query()->whereIn('name', [
            'manage courses',
            'manage lessons',
            'manage assessments',
        ])->where('guard_name', 'web')->get());
        $student->syncPermissions(Permission::query()->whereIn('name', [
            'view student dashboard',
        ])->where('guard_name', 'web')->get());

        $user = User::query()->updateOrCreate(
            ['email' => 'test@example.com'],
            [
                'name' => 'Test User',
                'password' => '123',
            ],
        );

        $user->assignRole($superAdmin);

        $this->call(AcademicStructureSeeder::class);
        $this->call(PeopleSeeder::class);
        $this->call(CourseSeeder::class);
        $this->call(ContentSeeder::class);
        $this->call(AllFeaturesSeeder::class);
    }
}
