<?php

namespace Database\Seeders;

use App\Models\Language;
use App\Models\Translation;
use App\Services\Localization\LocalizationService;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class LocalizationSeeder extends Seeder
{
    public function run(): void
    {
        $permissions = [
            'language.view',
            'language.create',
            'language.update',
            'language.delete',
            'translation.view',
            'translation.update',
            'translation.import',
            'translation.export',
        ];

        foreach ($permissions as $permission) {
            Permission::findOrCreate($permission, 'web');
        }

        foreach (['super_admin', 'admin'] as $roleName) {
            $role = Role::findOrCreate($roleName, 'web');
            $role->givePermissionTo($permissions);
        }

        $english = Language::query()->updateOrCreate(
            ['code' => 'en'],
            [
                'name' => 'English',
                'native_name' => 'English',
                'locale' => 'en',
                'flag' => 'backend/dist/img/lang/en.png',
                'is_default' => true,
                'is_active' => true,
                'direction' => 'ltr',
                'sort_order' => 10,
            ],
        );

        $khmer = Language::query()->updateOrCreate(
            ['code' => 'km'],
            [
                'name' => 'Khmer',
                'native_name' => 'ខ្មែរ',
                'locale' => 'km',
                'flag' => 'backend/dist/img/lang/kh.png',
                'is_default' => false,
                'is_active' => true,
                'direction' => 'ltr',
                'sort_order' => 20,
            ],
        );

        Language::query()->whereKeyNot($english->id)->update(['is_default' => false]);

        $translations = [
            'en' => [
                'frontend' => [
                    'brand' => 'Learning Management System',
                    'home' => 'Home',
                    'courses' => 'Courses',
                    'course_categories' => 'Course Categories',
                    'about' => 'About Us',
                    'more' => 'More',
                    'instructors' => 'Instructors',
                    'contact' => 'Contact Us',
                    'faq' => 'FAQ',
                    'dashboard' => 'Dashboard',
                    'my_dashboard' => 'My Dashboard',
                    'teacher_dashboard' => 'Teacher Dashboard',
                    'admin_dashboard' => 'Admin Dashboard',
                    'my_courses' => 'My Courses',
                    'create_course' => 'Create Course',
                    'manage_lessons' => 'Manage Lessons',
                    'my_students' => 'My Students',
                    'assignments' => 'Assignments',
                    'quizzes' => 'Quizzes',
                    'grades' => 'Grades',
                    'student_grades' => 'Student Grades',
                    'learning_progress' => 'Learning Progress',
                    'certificates' => 'Certificates',
                    'reports' => 'Reports',
                    'calendar' => 'Calendar',
                    'notifications' => 'Notifications',
                    'profile' => 'Profile',
                    'edit_profile' => 'Edit Profile',
                    'settings' => 'Settings',
                    'logout' => 'Logout',
                    'login' => 'Login',
                    'register' => 'Register',
                    'guest_user' => 'Guest User',
                    'language' => 'Language',
                    'search_placeholder' => 'Search courses...',
                    'search' => 'Search',
                    'menu' => 'Menu',
                ],
                'admin' => [
                    'groups.users' => 'User Management',
                    'groups.academic' => 'Academic Management',
                    'groups.students' => 'Student Management',
                    'groups.teachers' => 'Teacher Management',
                    'groups.content' => 'Learning Content',
                    'groups.assessment' => 'Assessment',
                    'groups.communication' => 'Communication',
                    'groups.finance' => 'Finance',
                    'groups.reports' => 'Reports',
                    'groups.settings' => 'Settings',
                    'groups.api' => 'API',
                    'nav.dashboard' => 'Dashboard',
                    'nav.users' => 'Users',
                    'nav.roles' => 'Roles',
                    'nav.permissions' => 'Permissions',
                    'nav.faculties' => 'Faculties',
                    'nav.departments' => 'Departments',
                    'nav.academic_years' => 'Academic Years',
                    'nav.semesters' => 'Semesters',
                    'nav.students' => 'Students',
                    'nav.enrollments' => 'Enrollments',
                    'nav.attendance' => 'Attendance',
                    'nav.promotions' => 'Promotions',
                    'nav.teachers' => 'Teachers',
                    'nav.course_assignments' => 'Course Assignments',
                    'nav.class_schedules' => 'Class Schedules',
                    'nav.course_categories' => 'Course Categories',
                    'nav.courses' => 'Courses',
                    'nav.class_rooms' => 'Class Rooms',
                    'nav.chapters' => 'Chapters',
                    'nav.lessons' => 'Lessons',
                    'nav.videos' => 'Videos',
                    'nav.documents' => 'Documents',
                    'nav.assignments' => 'Assignments',
                    'nav.resources' => 'Resources',
                    'nav.quizzes' => 'Quizzes',
                    'nav.question_banks' => 'Question Banks',
                    'nav.questions' => 'Questions',
                    'nav.exams' => 'Exams',
                    'nav.exam_schedule' => 'Exam Schedule',
                    'nav.exam_candidates' => 'Exam Candidates',
                    'nav.submissions' => 'Submissions',
                    'nav.assignment_submissions' => 'Assignment Submissions',
                    'nav.grading' => 'Grading',
                    'nav.results' => 'Results',
                    'nav.student_progress' => 'Student Progress',
                    'nav.certificates' => 'Certificates',
                    'nav.student_reports' => 'Student Reports',
                    'nav.attendance_reports' => 'Attendance Reports',
                    'nav.exam_reports' => 'Exam Reports',
                    'nav.finance_reports' => 'Finance Reports',
                    'nav.activity_logs' => 'Activity Logs',
                    'nav.languages' => 'Languages',
                    'nav.translations' => 'Translations',
                    'nav.my_courses' => 'My Courses',
                    'nav.available_courses' => 'Available Courses',
                    'nav.schedule' => 'Schedule',
                    'nav.quizzes_exams' => 'Quizzes / Exams',
                    'nav.grades' => 'Grades',
                    'nav.course_content' => 'Course Content',
                    'nav.gradebook' => 'Gradebook',
                    'nav.reports' => 'Reports',
                ],
            ],
            'km' => [
                'frontend' => [
                    'brand' => 'ប្រព័ន្ធគ្រប់គ្រងកម្មវិធីសិក្សា',
                    'home' => 'ទំព័រដើម',
                    'courses' => 'មុខវិជ្ជាសិក្សា',
                    'course_categories' => 'ប្រភេទមុខវិជ្ជា',
                    'about' => 'អំពីយើង',
                    'more' => 'ច្រើនទៀត',
                    'instructors' => 'គ្រូបង្រៀន',
                    'contact' => 'ទំនាក់ទំនង',
                    'faq' => 'សំណួរញឹកញាប់',
                    'dashboard' => 'ផ្ទាំងគ្រប់គ្រង',
                    'my_dashboard' => 'ផ្ទាំងគ្រប់គ្រងរបស់ខ្ញុំ',
                    'teacher_dashboard' => 'ផ្ទាំងគ្រប់គ្រងគ្រូបង្រៀន',
                    'admin_dashboard' => 'ផ្ទាំងគ្រប់គ្រងអ្នកគ្រប់គ្រង',
                    'my_courses' => 'មុខវិជ្ជារបស់ខ្ញុំ',
                    'create_course' => 'បង្កើតមុខវិជ្ជា',
                    'manage_lessons' => 'គ្រប់គ្រងមេរៀន',
                    'my_students' => 'សិស្សរបស់ខ្ញុំ',
                    'assignments' => 'កិច្ចការ',
                    'quizzes' => 'ការប្រឡងខ្លី',
                    'grades' => 'ពិន្ទុ',
                    'student_grades' => 'ពិន្ទុសិស្ស',
                    'learning_progress' => 'វឌ្ឍនភាពសិក្សា',
                    'certificates' => 'វិញ្ញាបនបត្រ',
                    'reports' => 'របាយការណ៍',
                    'calendar' => 'ប្រតិទិន',
                    'notifications' => 'ការជូនដំណឹង',
                    'profile' => 'ប្រវត្តិរូប',
                    'edit_profile' => 'កែសម្រួលព័ត៌មាន',
                    'settings' => 'ការកំណត់',
                    'logout' => 'ចាកចេញ',
                    'login' => 'ចូលប្រើប្រាស់',
                    'register' => 'ចុះឈ្មោះ',
                    'guest_user' => 'អ្នកប្រើជាភ្ញៀវ',
                    'language' => 'ភាសា',
                    'search_placeholder' => 'ស្វែងរកមុខវិជ្ជា...',
                    'search' => 'ស្វែងរក',
                    'menu' => 'ម៉ឺនុយ',
                ],
                'admin' => [
                    'groups.users' => 'គ្រប់គ្រងអ្នកប្រើប្រាស់',
                    'groups.academic' => 'គ្រប់គ្រងការសិក្សា',
                    'groups.students' => 'គ្រប់គ្រងនិស្សិត',
                    'groups.teachers' => 'គ្រប់គ្រងគ្រូបង្រៀន',
                    'groups.content' => 'មាតិកាសិក្សា',
                    'groups.assessment' => 'ការវាយតម្លៃ',
                    'groups.communication' => 'ការទំនាក់ទំនង',
                    'groups.finance' => 'ហិរញ្ញវត្ថុ',
                    'groups.reports' => 'របាយការណ៍',
                    'groups.settings' => 'ការកំណត់',
                    'groups.api' => 'ចំណុចប្រទាក់កម្មវិធី',
                    'nav.dashboard' => 'ផ្ទាំងគ្រប់គ្រង',
                    'nav.users' => 'អ្នកប្រើប្រាស់',
                    'nav.roles' => 'តួនាទី',
                    'nav.permissions' => 'សិទ្ធិ',
                    'nav.faculties' => 'មហាវិទ្យាល័យ',
                    'nav.departments' => 'ដេប៉ាតឺម៉ង់',
                    'nav.academic_years' => 'ឆ្នាំសិក្សា',
                    'nav.semesters' => 'ឆមាស',
                    'nav.students' => 'និស្សិត',
                    'nav.enrollments' => 'ការចុះឈ្មោះ',
                    'nav.attendance' => 'វត្តមាន',
                    'nav.promotions' => 'ការឡើងថ្នាក់',
                    'nav.teachers' => 'គ្រូបង្រៀន',
                    'nav.course_assignments' => 'ចាត់តាំងវគ្គសិក្សា',
                    'nav.class_schedules' => 'កាលវិភាគសិក្សា',
                    'nav.course_categories' => 'ប្រភេទវគ្គសិក្សា',
                    'nav.courses' => 'វគ្គសិក្សា',
                    'nav.class_rooms' => 'ថ្នាក់រៀន',
                    'nav.chapters' => 'ជំពូក',
                    'nav.lessons' => 'មេរៀន',
                    'nav.videos' => 'វីដេអូ',
                    'nav.documents' => 'ឯកសារ',
                    'nav.assignments' => 'កិច្ចការ',
                    'nav.resources' => 'ធនធាន',
                    'nav.quizzes' => 'តេស្តខ្លី',
                    'nav.question_banks' => 'ធនាគារសំណួរ',
                    'nav.questions' => 'សំណួរ',
                    'nav.exams' => 'ការប្រឡង',
                    'nav.exam_schedule' => 'កាលវិភាគប្រឡង',
                    'nav.exam_candidates' => 'បេក្ខជនប្រឡង',
                    'nav.submissions' => 'ការដាក់ស្នើ',
                    'nav.assignment_submissions' => 'ការដាក់ស្នើកិច្ចការ',
                    'nav.grading' => 'ការដាក់ពិន្ទុ',
                    'nav.results' => 'លទ្ធផល',
                    'nav.student_progress' => 'វឌ្ឍនភាពនិស្សិត',
                    'nav.certificates' => 'វិញ្ញាបនបត្រ',
                    'nav.student_reports' => 'របាយការណ៍និស្សិត',
                    'nav.attendance_reports' => 'របាយការណ៍វត្តមាន',
                    'nav.exam_reports' => 'របាយការណ៍ប្រឡង',
                    'nav.finance_reports' => 'របាយការណ៍ហិរញ្ញវត្ថុ',
                    'nav.activity_logs' => 'កំណត់ត្រាសកម្មភាព',
                    'nav.languages' => 'ភាសា',
                    'nav.translations' => 'ការបកប្រែ',
                    'nav.my_courses' => 'វគ្គសិក្សារបស់ខ្ញុំ',
                    'nav.available_courses' => 'វគ្គសិក្សាដែលមាន',
                    'nav.schedule' => 'កាលវិភាគ',
                    'nav.quizzes_exams' => 'តេស្ត / ការប្រឡង',
                    'nav.grades' => 'ពិន្ទុ',
                    'nav.course_content' => 'មាតិកាវគ្គសិក្សា',
                    'nav.gradebook' => 'សៀវភៅពិន្ទុ',
                    'nav.reports' => 'របាយការណ៍',
                ],
            ],
        ];

        foreach ([$english, $khmer] as $language) {
            foreach ($translations[$language->code] as $group => $items) {
                foreach ($items as $key => $value) {
                    Translation::query()->updateOrCreate(
                        ['language_id' => $language->id, 'group' => $group, 'key' => $key],
                        ['value' => $value],
                    );
                }
            }
        }

        app(LocalizationService::class)->clearCache();
    }
}
