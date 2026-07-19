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
            'users.view', 'users.create', 'users.update', 'users.delete',
            'roles.view', 'roles.create', 'roles.update', 'roles.delete',
            'academic.view', 'academic.create', 'academic.update', 'academic.delete',
            'students.view', 'students.create', 'students.update', 'students.delete',
            'courses.view', 'courses.create', 'courses.update', 'courses.delete',
            'lessons.view', 'lessons.create', 'lessons.update', 'lessons.delete',
            'assessments.view', 'assessments.create', 'assessments.update', 'assessments.delete',
            'promotions.view', 'promotions.create', 'promotions.update', 'promotions.delete',
        ];

        // ── Student permissions ───────────────────────────────────
        $studentPermissions = [
            'view student dashboard',
            'view my courses',
            'view available courses',
            'view assignments',
            'view quizzes',
            'view grades',
            'attendance.view',
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
            'attendance.view',
            'attendance.create',
            'attendance.update',
            'attendance.delete',
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
