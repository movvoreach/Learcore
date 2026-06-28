<?php

namespace Database\Seeders;

use App\Models\AcademicYear;
use App\Models\Department;
use App\Models\Semester;
use App\Models\Student;
use App\Models\Teacher;
use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class PeopleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Ensure Academic structure is seeded first if not already present
        if (Department::count() === 0 || AcademicYear::count() === 0) {
            $this->call(AcademicStructureSeeder::class);
        }

        $departments = Department::all();
        $academicYears = AcademicYear::with('semesters')->get();

        // 1. Seed 20 Teachers
        $teachersData = [
            ['first_name' => 'Alice', 'last_name' => 'Smith', 'gender' => 'Female', 'specialization' => 'Computer Networks'],
            ['first_name' => 'Bob', 'last_name' => 'Johnson', 'gender' => 'Male', 'specialization' => 'Thermodynamics'],
            ['first_name' => 'Charlie', 'last_name' => 'Brown', 'gender' => 'Male', 'specialization' => 'Marketing'],
            ['first_name' => 'Diana', 'last_name' => 'Prince', 'gender' => 'Female', 'specialization' => 'Quantum Mechanics'],
            ['first_name' => 'Evan', 'last_name' => 'Wright', 'gender' => 'Male', 'specialization' => 'Creative Writing'],
            ['first_name' => 'Fiona', 'last_name' => 'Gallagher', 'gender' => 'Female', 'specialization' => 'Curriculum Development'],
            ['first_name' => 'George', 'last_name' => 'Vance', 'gender' => 'Male', 'specialization' => 'Constitutional Law'],
            ['first_name' => 'Helen', 'last_name' => 'Cho', 'gender' => 'Female', 'specialization' => 'Pediatrics'],
            ['first_name' => 'Ian', 'last_name' => 'Malcolm', 'gender' => 'Male', 'specialization' => 'Pharmacology'],
            ['first_name' => 'Julia', 'last_name' => 'Roberts', 'gender' => 'Female', 'specialization' => 'General Nursing'],
            ['first_name' => 'Kevin', 'last_name' => 'Spacey', 'gender' => 'Male', 'specialization' => 'Urban Planning'],
            ['first_name' => 'Laura', 'last_name' => 'Croft', 'gender' => 'Female', 'specialization' => 'Microeconomics'],
            ['first_name' => 'Michael', 'last_name' => 'Scott', 'gender' => 'Male', 'specialization' => 'Management'],
            ['first_name' => 'Nancy', 'last_name' => 'Drew', 'gender' => 'Female', 'specialization' => 'Agronomy'],
            ['first_name' => 'Oscar', 'last_name' => 'Wilde', 'gender' => 'Male', 'specialization' => 'Art History'],
            ['first_name' => 'Peter', 'last_name' => 'Parker', 'gender' => 'Male', 'specialization' => 'Photojournalism'],
            ['first_name' => 'Quincy', 'last_name' => 'Adams', 'gender' => 'Male', 'specialization' => 'Linguistics'],
            ['first_name' => 'Rachel', 'last_name' => 'Green', 'gender' => 'Female', 'specialization' => 'Cognitive Psychology'],
            ['first_name' => 'Steven', 'last_name' => 'Spielberg', 'gender' => 'Male', 'specialization' => 'Hospitality Management'],
            ['first_name' => 'Thomas', 'last_name' => 'Edison', 'gender' => 'Male', 'specialization' => 'Music Theory'],
        ];

        $teacherRole = Role::findOrCreate('teacher', 'web');

        foreach ($teachersData as $index => $data) {
            $email = strtolower($data['first_name'] . '.' . $data['last_name'] . '@example.com');
            
            // Create user
            $user = User::updateOrCreate(
                ['email' => $email],
                [
                    'name' => $data['first_name'] . ' ' . $data['last_name'],
                    'password' => '123', // Automatically hashed via casts
                ]
            );

            if (!$user->hasRole('teacher')) {
                $user->assignRole($teacherRole);
            }

            $dept = $departments->isNotEmpty() ? $departments->get($index % $departments->count()) : null;

            Teacher::updateOrCreate(
                ['email' => $email],
                [
                    'user_id' => $user->id,
                    'department_id' => $dept?->department_id,
                    'first_name' => $data['first_name'],
                    'last_name' => $data['last_name'],
                    'gender' => $data['gender'],
                    'phone' => '+1555' . str_pad((string)$index, 7, '0', STR_PAD_LEFT),
                    'specialization' => $data['specialization'],
                    'hire_date' => now()->subYears(rand(1, 10))->format('Y-m-d'),
                    'status' => 'active',
                    'employment_type' => 'full_time',
                    'address' => 'University Boulevard Street ' . ($index + 1),
                ]
            );
        }

        // 2. Seed 20 Students
        $studentsData = [
            ['first_name' => 'James', 'last_name' => 'Wilson', 'gender' => 'Male'],
            ['first_name' => 'Mary', 'last_name' => 'Taylor', 'gender' => 'Female'],
            ['first_name' => 'John', 'last_name' => 'Anderson', 'gender' => 'Male'],
            ['first_name' => 'Patricia', 'last_name' => 'Thomas', 'gender' => 'Female'],
            ['first_name' => 'Robert', 'last_name' => 'Jackson', 'gender' => 'Male'],
            ['first_name' => 'Jennifer', 'last_name' => 'White', 'gender' => 'Female'],
            ['first_name' => 'Michael', 'last_name' => 'Harris', 'gender' => 'Male'],
            ['first_name' => 'Elizabeth', 'last_name' => 'Martin', 'gender' => 'Female'],
            ['first_name' => 'William', 'last_name' => 'Thompson', 'gender' => 'Male'],
            ['first_name' => 'Linda', 'last_name' => 'Garcia', 'gender' => 'Female'],
            ['first_name' => 'David', 'last_name' => 'Martinez', 'gender' => 'Male'],
            ['first_name' => 'Barbara', 'last_name' => 'Robinson', 'gender' => 'Female'],
            ['first_name' => 'Richard', 'last_name' => 'Clark', 'gender' => 'Male'],
            ['first_name' => 'Susan', 'last_name' => 'Rodriguez', 'gender' => 'Female'],
            ['first_name' => 'Joseph', 'last_name' => 'Lewis', 'gender' => 'Male'],
            ['first_name' => 'Margaret', 'last_name' => 'Lee', 'gender' => 'Female'],
            ['first_name' => 'Charles', 'last_name' => 'Walker', 'gender' => 'Male'],
            ['first_name' => 'Dorothy', 'last_name' => 'Hall', 'gender' => 'Female'],
            ['first_name' => 'Thomas', 'last_name' => 'Allen', 'gender' => 'Male'],
            ['first_name' => 'Lisa', 'last_name' => 'Young', 'gender' => 'Female'],
        ];

        $studentRole = Role::findOrCreate('student', 'web');

        foreach ($studentsData as $index => $data) {
            $email = strtolower($data['first_name'] . '.' . $data['last_name'] . '@example.com');

            // Create user
            $user = User::updateOrCreate(
                ['email' => $email],
                [
                    'name' => $data['first_name'] . ' ' . $data['last_name'],
                    'password' => '123', // Automatically hashed via casts
                ]
            );

            if (!$user->hasRole('student')) {
                $user->assignRole($studentRole);
            }

            $dept = $departments->isNotEmpty() ? $departments->get(($index + 5) % $departments->count()) : null;
            $acadYear = $academicYears->isNotEmpty() ? $academicYears->get($index % $academicYears->count()) : null;
            $sem = ($acadYear && $acadYear->semesters->isNotEmpty()) ? $acadYear->semesters->first() : null;

            Student::updateOrCreate(
                ['email' => $email],
                [
                    'user_id' => $user->id,
                    'department_id' => $dept?->department_id,
                    'academic_year_id' => $acadYear?->academic_year_id,
                    'semester_id' => $sem?->semester_id,
                    'first_name' => $data['first_name'],
                    'last_name' => $data['last_name'],
                    'gender' => $data['gender'],
                    'phone' => '+1666' . str_pad((string)$index, 7, '0', STR_PAD_LEFT),
                    'date_of_birth' => now()->subYears(rand(18, 25))->format('Y-m-d'),
                    'status' => 'active',
                    'address' => 'Student Residence Block ' . ($index + 1),
                ]
            );
        }
    }
}
