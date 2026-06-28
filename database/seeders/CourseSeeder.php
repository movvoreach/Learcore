<?php

namespace Database\Seeders;

use App\Models\AcademicYear;
use App\Models\Course;
use App\Models\CourseCategory;
use App\Models\Department;
use App\Models\Semester;
use Illuminate\Database\Seeder;

class CourseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Seed 10 Course Categories
        $categoriesData = [
            ['code' => 'CSSE', 'name' => 'Computer Science & Software Engineering', 'description' => 'Courses covering core computer science principles, programming, and software design.'],
            ['code' => 'NETSEC', 'name' => 'Networking & Information Security', 'description' => 'Courses focused on routing, switching, cryptography, and securing information networks.'],
            ['code' => 'AIDS', 'name' => 'Artificial Intelligence & Data Science', 'description' => 'Courses exploring machine learning, deep learning, big data, and data visualization.'],
            ['code' => 'BUSMKT', 'name' => 'Business Administration & Marketing', 'description' => 'Courses related to organizational management, human resources, and marketing strategies.'],
            ['code' => 'FINACC', 'name' => 'Finance & Accounting', 'description' => 'Courses addressing financial accounting, economics, corporate finance, and investing.'],
            ['code' => 'CIVENG', 'name' => 'Civil & Structural Engineering', 'description' => 'Courses covering structural mechanics, geotechnical engineering, and construction materials.'],
            ['code' => 'MECHENG', 'name' => 'Mechanical & Electrical Engineering', 'description' => 'Courses in fluid mechanics, thermodynamics, electrical circuits, and automation.'],
            ['code' => 'PHYAST', 'name' => 'Physics & Astronomy', 'description' => 'Courses covering mechanics, electromagnetism, modern physics, and astronomical sciences.'],
            ['code' => 'LINLAN', 'name' => 'Linguistics & Languages', 'description' => 'Courses focused on language acquisition, technical writing, and communication.'],
            ['code' => 'CLINHLTH', 'name' => 'Clinical & Health Sciences', 'description' => 'Courses addressing anatomy, pharmacology, clinical nursing, and public health.'],
        ];

        $categories = [];
        foreach ($categoriesData as $cat) {
            $categories[] = CourseCategory::updateOrCreate(
                ['category_code' => $cat['code']],
                [
                    'category_name' => $cat['name'],
                    'description' => $cat['description']
                ]
            );
        }

        // Fetch departments, academic years, and semesters
        $departments = Department::all();
        $academicYears = AcademicYear::with('semesters')->get();

        // 2. Seed 50 Courses
        $coursesData = [
            ['code' => 'CS-101', 'name' => 'Introduction to Computer Science', 'cat_idx' => 0],
            ['code' => 'CS-102', 'name' => 'Object-Oriented Programming', 'cat_idx' => 0],
            ['code' => 'CS-201', 'name' => 'Data Structures and Algorithms', 'cat_idx' => 0],
            ['code' => 'CS-202', 'name' => 'Database Management Systems', 'cat_idx' => 0],
            ['code' => 'CS-301', 'name' => 'Web Application Development', 'cat_idx' => 0],
            ['code' => 'CS-302', 'name' => 'Mobile Application Development', 'cat_idx' => 0],
            ['code' => 'CS-401', 'name' => 'Software Engineering Principles', 'cat_idx' => 0],
            ['code' => 'CS-402', 'name' => 'Cloud Computing Solutions', 'cat_idx' => 0],
            
            ['code' => 'NET-101', 'name' => 'Computer Networks Fundamentals', 'cat_idx' => 1],
            ['code' => 'NET-201', 'name' => 'Network Security & Cryptography', 'cat_idx' => 1],
            ['code' => 'NET-301', 'name' => 'Cyber Security Operations', 'cat_idx' => 1],
            ['code' => 'NET-401', 'name' => 'Ethical Hacking & Penetration Testing', 'cat_idx' => 1],
            
            ['code' => 'AI-101', 'name' => 'Introduction to Artificial Intelligence', 'cat_idx' => 2],
            ['code' => 'AI-201', 'name' => 'Machine Learning Algorithms', 'cat_idx' => 2],
            ['code' => 'AI-301', 'name' => 'Deep Learning & Neural Networks', 'cat_idx' => 2],
            ['code' => 'DS-101', 'name' => 'Data Science Fundamentals', 'cat_idx' => 2],
            ['code' => 'DS-201', 'name' => 'Big Data Analytics', 'cat_idx' => 2],
            
            ['code' => 'BUS-101', 'name' => 'Business Communication Basics', 'cat_idx' => 3],
            ['code' => 'BUS-102', 'name' => 'Principles of Marketing', 'cat_idx' => 3],
            ['code' => 'BUS-201', 'name' => 'Human Resource Management', 'cat_idx' => 3],
            ['code' => 'BUS-301', 'name' => 'Strategic Management & Planning', 'cat_idx' => 3],
            
            ['code' => 'ACC-101', 'name' => 'Financial Accounting I', 'cat_idx' => 4],
            ['code' => 'FIN-201', 'name' => 'Corporate Finance Theory', 'cat_idx' => 4],
            ['code' => 'FIN-301', 'name' => 'Investment Portfolio Management', 'cat_idx' => 4],
            
            ['code' => 'MATH-101', 'name' => 'Calculus for Engineers', 'cat_idx' => 4],
            ['code' => 'MATH-102', 'name' => 'Linear Algebra & Geometry', 'cat_idx' => 4],
            ['code' => 'MATH-201', 'name' => 'Probability and Statistics', 'cat_idx' => 4],
            
            ['code' => 'PHYS-101', 'name' => 'Classical Mechanics', 'cat_idx' => 7],
            ['code' => 'PHYS-102', 'name' => 'Thermodynamics & Heat Transfer', 'cat_idx' => 7],
            ['code' => 'PHYS-201', 'name' => 'Electromagnetism Theory', 'cat_idx' => 7],
            ['code' => 'CHEM-101', 'name' => 'Organic Chemistry Basics', 'cat_idx' => 7],
            ['code' => 'BIO-101', 'name' => 'Introduction to Genetics', 'cat_idx' => 7],
            
            ['code' => 'CIV-201', 'name' => 'Structural Analysis I', 'cat_idx' => 5],
            ['code' => 'CIV-301', 'name' => 'Soil Mechanics & Foundations', 'cat_idx' => 5],
            
            ['code' => 'MECH-201', 'name' => 'Fluid Mechanics Principles', 'cat_idx' => 6],
            ['code' => 'MECH-301', 'name' => 'Mechanical Design & Modeling', 'cat_idx' => 6],
            ['code' => 'MECH-401', 'name' => 'Control Systems Engineering', 'cat_idx' => 6],
            
            ['code' => 'ENG-101', 'name' => 'English Composition and Rhetoric', 'cat_idx' => 8],
            ['code' => 'ENG-201', 'name' => 'Technical Writing for Engineers', 'cat_idx' => 8],
            ['code' => 'SOC-101', 'name' => 'Introduction to Sociology', 'cat_idx' => 8],
            ['code' => 'ECON-101', 'name' => 'Principles of Macroeconomics', 'cat_idx' => 8],
            
            ['code' => 'MED-201', 'name' => 'General Pathology', 'cat_idx' => 9],
            ['code' => 'PHA-201', 'name' => 'Pharmacology Principles', 'cat_idx' => 9],
            ['code' => 'NUR-101', 'name' => 'Patient Care & Nursing Ethics', 'cat_idx' => 9],
            
            ['code' => 'ARCH-101', 'name' => 'History of World Architecture', 'cat_idx' => 5],
            ['code' => 'ARCH-201', 'name' => 'Interior Design Concepts', 'cat_idx' => 5],
            ['code' => 'JOUR-101', 'name' => 'Introduction to Journalism', 'cat_idx' => 8],
            ['code' => 'JOUR-201', 'name' => 'Public Relations Campaigns', 'cat_idx' => 8],
            ['code' => 'MUS-101', 'name' => 'Basic Music Theory', 'cat_idx' => 8],
            ['code' => 'ART-101', 'name' => 'History of Western Art', 'cat_idx' => 8],
        ];

        foreach ($coursesData as $index => $data) {
            $cat = $categories[$data['cat_idx']];
            $dept = $departments->isNotEmpty() ? $departments->get($index % $departments->count()) : null;
            $acadYear = $academicYears->isNotEmpty() ? $academicYears->get($index % $academicYears->count()) : null;
            $sem = ($acadYear && $acadYear->semesters->isNotEmpty()) ? $acadYear->semesters->first() : null;

            Course::updateOrCreate(
                ['course_code' => $data['code']],
                [
                    'course_category_id' => $cat->course_category_id,
                    'department_id' => $dept?->department_id,
                    'academic_year_id' => $acadYear?->academic_year_id,
                    'semester_id' => $sem?->semester_id,
                    'course_name' => $data['name'],
                    'description' => "This is a detailed course description for {$data['name']} ({$data['code']}).",
                ]
            );
        }
    }
}
