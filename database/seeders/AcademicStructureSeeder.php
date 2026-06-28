<?php

namespace Database\Seeders;

use App\Models\AcademicYear;
use App\Models\Department;
use App\Models\Faculty;
use App\Models\Semester;
use Illuminate\Database\Seeder;

class AcademicStructureSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Seed 20 Faculties and their corresponding Departments
        $facultiesWithDepartments = [
            'Faculty of Computer Science and Information Technology' => [
                'name' => 'Department of Software Engineering',
                'deans' => 'Dr. Alice Smith',
            ],
            'Faculty of Engineering and Technology' => [
                'name' => 'Department of Civil Engineering',
                'deans' => 'Dr. Bob Johnson',
            ],
            'Faculty of Business Administration' => [
                'name' => 'Department of Marketing',
                'deans' => 'Dr. Charlie Brown',
            ],
            'Faculty of Science' => [
                'name' => 'Department of Physics',
                'deans' => 'Dr. Diana Prince',
            ],
            'Faculty of Arts and Humanities' => [
                'name' => 'Department of English Literature',
                'deans' => 'Dr. Evan Wright',
            ],
            'Faculty of Education' => [
                'name' => 'Department of Educational Leadership',
                'deans' => 'Dr. Fiona Gallagher',
            ],
            'Faculty of Law' => [
                'name' => 'Department of Civil Law',
                'deans' => 'Dr. George Vance',
            ],
            'Faculty of Medicine' => [
                'name' => 'Department of General Medicine',
                'deans' => 'Dr. Helen Cho',
            ],
            'Faculty of Pharmacy' => [
                'name' => 'Department of Clinical Pharmacy',
                'deans' => 'Dr. Ian Malcolm',
            ],
            'Faculty of Nursing' => [
                'name' => 'Department of Pediatric Nursing',
                'deans' => 'Dr. Julia Roberts',
            ],
            'Faculty of Architecture and Design' => [
                'name' => 'Department of Interior Design',
                'deans' => 'Dr. Kevin Spacey',
            ],
            'Faculty of Economics and Political Science' => [
                'name' => 'Department of Economics',
                'deans' => 'Dr. Laura Croft',
            ],
            'Faculty of Social Sciences' => [
                'name' => 'Department of Sociology',
                'deans' => 'Dr. Michael Scott',
            ],
            'Faculty of Agriculture' => [
                'name' => 'Department of Crop Science',
                'deans' => 'Dr. Nancy Drew',
            ],
            'Faculty of Fine Arts' => [
                'name' => 'Department of Painting and Sculpture',
                'deans' => 'Dr. Oscar Wilde',
            ],
            'Faculty of Journalism and Communication' => [
                'name' => 'Department of Public Relations',
                'deans' => 'Dr. Peter Parker',
            ],
            'Faculty of Foreign Languages' => [
                'name' => 'Department of Linguistics',
                'deans' => 'Dr. Quincy Adams',
            ],
            'Faculty of Psychology' => [
                'name' => 'Department of Clinical Psychology',
                'deans' => 'Dr. Rachel Green',
            ],
            'Faculty of Tourism and Hospitality' => [
                'name' => 'Department of Hotel Management',
                'deans' => 'Dr. Steven Spielberg',
            ],
            'Faculty of Music and Performing Arts' => [
                'name' => 'Department of Musicology',
                'deans' => 'Dr. Thomas Edison',
            ],
        ];

        foreach ($facultiesWithDepartments as $facultyName => $deptInfo) {
            $faculty = Faculty::updateOrCreate(
                ['faculty_name' => $facultyName]
            );

            Department::updateOrCreate(
                [
                    'faculty_id' => $faculty->faculty_id,
                    'department_name' => $deptInfo['name']
                ],
                [
                    'deans' => $deptInfo['deans']
                ]
            );
        }

        // 2. Seed 20 Academic Years and Semesters
        // We will seed 20 years from 2007-2008 to 2026-2027
        $currentYear = 2026;
        for ($i = 19; $i >= 0; $i--) {
            $startYear = $currentYear - $i;
            $endYear = $startYear + 1;
            $yearName = "{$startYear}-{$endYear}";
            
            // Let 2025-2026 be the active year based on the current date (June 2026)
            $isActiveYear = ($yearName === '2025-2026');

            $academicYear = AcademicYear::updateOrCreate(
                ['year_name' => $yearName],
                [
                    'start_date' => "{$startYear}-09-01",
                    'end_date' => "{$endYear}-08-31",
                    'is_active' => $isActiveYear,
                ]
            );

            // Seed 2 semesters for each academic year
            // Semester 1
            $isActiveSem1 = ($isActiveYear && (date('n') >= 9 || date('n') <= 1)); // Sept to Jan
            Semester::updateOrCreate(
                [
                    'academic_year_id' => $academicYear->academic_year_id,
                    'semester_name' => 'Semester 1'
                ],
                [
                    'start_date' => "{$startYear}-09-01",
                    'end_date' => "{$startYear}-12-31",
                    'is_active' => $isActiveSem1,
                ]
            );

            // Semester 2
            $isActiveSem2 = ($isActiveYear && date('n') >= 2 && date('n') <= 8); // Feb to Aug
            Semester::updateOrCreate(
                [
                    'academic_year_id' => $academicYear->academic_year_id,
                    'semester_name' => 'Semester 2'
                ],
                [
                    'start_date' => "{$endYear}-01-01",
                    'end_date' => "{$endYear}-06-30",
                    'is_active' => $isActiveSem2,
                ]
            );
        }
    }
}
