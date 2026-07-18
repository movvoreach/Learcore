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

        // ── Admin / Global permissions ────────────────────────────
        $adminPermissions = [
            'manage users',
            'manage roles',
            'manage academic structure',
            'manage students',
            'manage courses',
            'manage lessons',
            'manage assessments',
            'manage promotions',
        ];

        // ── Student permissions ───────────────────────────────────
        $studentPermissions = [
            'view student dashboard',
            'view my courses',
            'view available courses',
            'view assignments',
            'view quizzes',
            'view grades',
            'view attendance',
            'view certificates',
        ];

        // ── Teacher permissions ───────────────────────────────────
        $teacherPermissions = [
            'view teacher dashboard',
            'view teacher courses',
            'create courses',
            'manage course content',
            'view course students',
            'manage assignments',
            'manage quizzes',
            'manage gradebook',
            'manage attendance',
            'view reports',
        ];

        $allPermissionNames = array_merge($adminPermissions, $studentPermissions, $teacherPermissions);

        foreach ($allPermissionNames as $permission) {
            Permission::findOrCreate($permission, 'web');
        }

        $superAdmin = Role::findOrCreate('super_admin', 'web');
        $admin = Role::findOrCreate('admin', 'web');
        $teacher = Role::findOrCreate('teacher', 'web');
        $student = Role::findOrCreate('student', 'web');

        $allPermissions = Permission::query()->whereIn('name', $allPermissionNames)->where('guard_name', 'web')->get();

        $superAdmin->syncPermissions($allPermissions);
        $admin->syncPermissions($allPermissions);

        $teacher->syncPermissions(Permission::query()->whereIn('name', $teacherPermissions)->where('guard_name', 'web')->get());
        $student->syncPermissions(Permission::query()->whereIn('name', $studentPermissions)->where('guard_name', 'web')->get());

        $this->call(LocalizationSeeder::class);
        $this->call(PeopleSeeder::class);
    }
}
