<?php

namespace App\Filament\Admin\Pages;

use App\Filament\Admin\Resources\Attendances\AttendanceResource;
use App\Filament\Admin\Resources\Certificates\CertificateResource;
use App\Filament\Admin\Resources\ContentLessons\ContentLessonResource;
use App\Filament\Admin\Resources\Departments\DepartmentResource;
use App\Filament\Admin\Resources\Exams\ExamResource;
use App\Filament\Admin\Resources\Students\StudentResource;
use App\Filament\Admin\Resources\Subjects\SubjectResource;
use App\Filament\Admin\Resources\Teachers\TeacherResource;
use App\Models\AssessmentGrade;
use App\Models\Attendance;
use App\Models\Certificate;
use App\Models\ContentAssignment;
use App\Models\ContentLesson;
use App\Models\Course;
use App\Models\Department;
use App\Models\Enrollment;
use App\Models\Exam;
use App\Models\Student;
use App\Models\StudentProgress;
use App\Models\Subject;
use App\Models\Teacher;
use BackedEnum;
use Filament\Pages\Dashboard as BaseDashboard;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\HtmlString;

class Dashboard extends BaseDashboard
{
    protected static string|BackedEnum|null $navigationIcon = null;

    protected static ?string $navigationLabel = 'ផ្ទាំងគ្រប់គ្រង';

    protected static ?string $title = 'ផ្ទាំងគ្រប់គ្រង';

    protected string $view = 'filament.admin.pages.dashboard';

    public static function getNavigationIcon(): string|BackedEnum|Htmlable|null
    {
        return new HtmlString('<img src="'.e(asset('Icons/dashbords.png')).'" alt="" class="fi-sidebar-item-icon" />');
    }

    /**
     * @return array<string, mixed>
     */
    protected function getViewData(): array
    {
        $user = auth()->user();
        if ($user && $user->hasRole('student')) {
            return $this->studentViewData($user->student);
        }

        try {
            return Cache::remember('filament.admin.dashboard.full.links', now()->addMinutes(5), function () {
            // ── Basic counts ──────────────────────────────────────────
            $totalStudents   = Student::query()->count();
            $activeStudents  = Student::query()->where('status', 'active')->count();
            $totalTeachers   = Teacher::query()->count();
            $totalSubjects   = Subject::query()->count();
            $totalLessons    = ContentLesson::query()->count();
            $totalDepts      = Department::query()->count();
            $totalExams      = Exam::query()->count();
            $totalAttendance = Attendance::query()->count();
            $totalCerts      = Certificate::query()->count();
            $totalEnrollments = Enrollment::query()->count();

            // ── Stats cards ───────────────────────────────────────────
            $stats = [
                ['label' => 'និស្សិត',       'value' => $totalStudents,    'sub' => $activeStudents.' សកម្ម',          'color' => '#2563eb', 'fa_icon' => 'fas fa-user-graduate', 'icon' => '🎓'],
                ['label' => 'គ្រូបង្រៀន',   'value' => $totalTeachers,    'sub' => 'សរុបគ្រូ',                         'color' => '#7c3aed', 'fa_icon' => 'fas fa-chalkboard-teacher', 'icon' => '👨‍🏫'],
                ['label' => 'មុខវិជ្ជា',     'value' => $totalSubjects,     'sub' => 'សរុបមុខវិជ្ជា',                   'color' => '#059669', 'fa_icon' => 'fas fa-book-open', 'icon' => '📚'],
                ['label' => 'មេរៀន',         'value' => $totalLessons,     'sub' => 'សរុបមេរៀន',                       'color' => '#d97706', 'fa_icon' => 'fas fa-file-alt', 'icon' => '📖'],
                ['label' => 'នាយកដ្ឋាន',    'value' => $totalDepts,       'sub' => 'ផ្នែក',                           'color' => '#dc2626', 'fa_icon' => 'fas fa-building', 'icon' => '🏫'],
                ['label' => 'ការប្រឡង',      'value' => $totalExams,       'sub' => 'ការប្រឡង',                        'color' => '#0891b2', 'fa_icon' => 'fas fa-file-signature', 'icon' => '📝'],
                ['label' => 'វត្តមាន',       'value' => $totalAttendance,  'sub' => 'កំណត់ត្រា',                       'color' => '#65a30d', 'fa_icon' => 'fas fa-user-check', 'icon' => '✅'],
                ['label' => 'វិញ្ញាបនប័ត្រ', 'value' => $totalCerts,       'sub' => 'ផ្តល់ជូន',                        'color' => '#e11d48', 'fa_icon' => 'fas fa-award', 'icon' => '🏆'],
            ];
            $stats = collect($stats)
                ->zip([
                    StudentResource::getUrl('index'),
                    TeacherResource::getUrl('index'),
                    SubjectResource::getUrl('index'),
                    ContentLessonResource::getUrl('index'),
                    DepartmentResource::getUrl('index'),
                    ExamResource::getUrl('index'),
                    AttendanceResource::getUrl('index'),
                    CertificateResource::getUrl('index'),
                ])
                ->map(fn ($stat): array => array_merge($stat[0], ['url' => $stat[1]]))
                ->all();

            // ── Monthly enrollments — last 6 months ───────────────────
            $months = collect(range(5, 0))->map(fn ($i) => Carbon::now()->subMonths($i));
            $monthlyStart = Carbon::now()->subMonths(6)->startOfMonth();
            $enrollmentByMonth = $this->monthlyCreatedAtCounts(Enrollment::class, $monthlyStart);

            $enrollmentLabels = $months->map(fn ($m) => $m->format('M Y'))->values()->toArray();
            $enrollmentData   = $months->map(fn ($m) => (int) ($enrollmentByMonth[$m->year.'-'.$m->month] ?? 0))->values()->toArray();

            // ── Monthly lessons created — last 6 months ───────────────
            $lessonsByMonth = $this->monthlyCreatedAtCounts(ContentLesson::class, $monthlyStart);

            $lessonsData = $months->map(fn ($m) => (int) ($lessonsByMonth[$m->year.'-'.$m->month] ?? 0))->values()->toArray();

            // ── Student status breakdown ───────────────────────────────
            $studentStatus = Student::query()
                ->selectRaw('status, COUNT(*) as total')
                ->groupBy('status')
                ->pluck('total', 'status')
                ->toArray();

            // ── Students by department ────────────────────────────────
            $studentsByDept = Student::query()
                ->join('departments', 'students.department_id', '=', 'departments.department_id')
                ->selectRaw('departments.department_name, COUNT(students.student_id) as total')
                ->groupBy('departments.department_id', 'departments.department_name')
                ->orderByDesc('total')
                ->limit(6)
                ->pluck('total', 'department_name')
                ->toArray();

            // ── Top courses by lesson count ────────────────────────────
            $topCourses = Course::query()
                ->with(['department', 'academicYear', 'semester'])
                ->withCount('contentLessons')
                ->orderByDesc('content_lessons_count')
                ->limit(8)
                ->get();

            $maxLessons = $topCourses->max('content_lessons_count') ?: 1;

            // ── Recent students ───────────────────────────────────────
            $recentStudents = Student::query()
                ->with(['department', 'academicYear', 'semester'])
                ->latest('student_id')
                ->limit(8)
                ->get();

            // ── Recent enrollments ────────────────────────────────────
            $recentEnrollments = Enrollment::query()
                ->with(['student', 'course'])
                ->latest()
                ->limit(6)
                ->get();

            return [
                'mode'               => 'admin',
                'stats'              => $stats,
                'enrollmentLabels'   => $enrollmentLabels,
                'enrollmentData'     => $enrollmentData,
                'lessonsData'        => $lessonsData,
                'studentStatus'      => $studentStatus,
                'studentsByDept'     => $studentsByDept,
                'courses'            => $topCourses,
                'topCourses'         => $topCourses,
                'maxLessons'         => $maxLessons,
                'recentStudents'     => $recentStudents,
                'recentEnrollments'  => $recentEnrollments,
                'totalEnrollments'   => $totalEnrollments,
            ];
        });
        } catch (\Exception $e) {
            return $this->staticAdminViewData();
        }
    }

    /**
     * @return array<string, mixed>
     */
    private function staticAdminViewData(): array
    {
        $courses = collect([
            (object) [
                'course_name' => 'Web Development',
                'department' => (object) ['department_name' => 'Information Technology'],
                'academicYear' => (object) ['year_name' => 'Year 1'],
                'semester' => (object) ['semester_name' => 'Semester 1'],
                'content_lessons_count' => 12,
            ],
            (object) [
                'course_name' => 'Database Systems',
                'department' => (object) ['department_name' => 'Computer Science'],
                'academicYear' => (object) ['year_name' => 'Year 2'],
                'semester' => (object) ['semester_name' => 'Semester 1'],
                'content_lessons_count' => 9,
            ],
            (object) [
                'course_name' => 'Business English',
                'department' => (object) ['department_name' => 'General Education'],
                'academicYear' => (object) ['year_name' => 'Year 1'],
                'semester' => (object) ['semester_name' => 'Semester 2'],
                'content_lessons_count' => 8,
            ],
            (object) [
                'course_name' => 'Network Fundamentals',
                'department' => (object) ['department_name' => 'Information Technology'],
                'academicYear' => (object) ['year_name' => 'Year 2'],
                'semester' => (object) ['semester_name' => 'Semester 2'],
                'content_lessons_count' => 10,
            ],
        ]);

        $recentStudents = collect([
            (object) [
                'first_name' => 'Sok',
                'last_name' => 'Dara',
                'department' => (object) ['department_name' => 'Information Technology'],
                'academicYear' => (object) ['year_name' => 'Year 1'],
                'semester' => (object) ['semester_name' => 'Semester 1'],
                'status' => 'active',
            ],
            (object) [
                'first_name' => 'Chan',
                'last_name' => 'Sophea',
                'department' => (object) ['department_name' => 'Computer Science'],
                'academicYear' => (object) ['year_name' => 'Year 2'],
                'semester' => (object) ['semester_name' => 'Semester 1'],
                'status' => 'active',
            ],
            (object) [
                'first_name' => 'Kim',
                'last_name' => 'Sothea',
                'department' => (object) ['department_name' => 'Accounting'],
                'academicYear' => (object) ['year_name' => 'Year 3'],
                'semester' => (object) ['semester_name' => 'Semester 2'],
                'status' => 'active',
            ],
            (object) [
                'first_name' => 'Lim',
                'last_name' => 'Bopha',
                'department' => (object) ['department_name' => 'Management'],
                'academicYear' => (object) ['year_name' => 'Year 1'],
                'semester' => (object) ['semester_name' => 'Semester 2'],
                'status' => 'inactive',
            ],
        ]);

        return [
            'mode' => 'admin',
            'stats' => [
                ['label' => 'Students', 'value' => 128, 'sub' => '112 active', 'color' => '#2563eb', 'icon' => '', 'url' => StudentResource::getUrl('index')],
                ['label' => 'Teachers', 'value' => 24, 'sub' => 'Total teachers', 'color' => '#7c3aed', 'icon' => '', 'url' => TeacherResource::getUrl('index')],
                ['label' => 'Subjects', 'value' => 36, 'sub' => 'Learning subjects', 'color' => '#059669', 'icon' => '', 'url' => SubjectResource::getUrl('index')],
                ['label' => 'Lessons', 'value' => 214, 'sub' => 'Published lessons', 'color' => '#d97706', 'icon' => '', 'url' => ContentLessonResource::getUrl('index')],
                ['label' => 'Departments', 'value' => 8, 'sub' => 'Academic departments', 'color' => '#dc2626', 'icon' => '', 'url' => DepartmentResource::getUrl('index')],
                ['label' => 'Exams', 'value' => 18, 'sub' => 'Scheduled exams', 'color' => '#0891b2', 'icon' => '', 'url' => ExamResource::getUrl('index')],
                ['label' => 'Attendance', 'value' => 982, 'sub' => 'Attendance records', 'color' => '#65a30d', 'icon' => '', 'url' => AttendanceResource::getUrl('index')],
                ['label' => 'Certificates', 'value' => 47, 'sub' => 'Issued certificates', 'color' => '#e11d48', 'icon' => '', 'url' => CertificateResource::getUrl('index')],
            ],
            'courses' => $courses,
            'topCourses' => $courses,
            'maxLessons' => 12,
            'recentStudents' => $recentStudents,
            'recentEnrollments' => collect(),
            'enrollmentLabels' => ['Jan 2026', 'Feb 2026', 'Mar 2026', 'Apr 2026', 'May 2026', 'Jun 2026'],
            'enrollmentData' => [12, 18, 15, 22, 26, 35],
            'lessonsData' => [24, 31, 28, 36, 40, 55],
            'studentStatus' => ['active' => 112, 'inactive' => 16],
            'studentsByDept' => [
                'Information Technology' => 42,
                'Computer Science' => 35,
                'Accounting' => 24,
                'Management' => 27,
            ],
            'totalEnrollments' => 186,
        ];
    }

    /**
     * @return array<string, int>
     */
    private function monthlyCreatedAtCounts(string $modelClass, Carbon $start): array
    {
        [$select, $groupBy] = $this->yearMonthSql('created_at');

        return $modelClass::query()
            ->selectRaw($select.', COUNT(*) as total')
            ->where('created_at', '>=', $start)
            ->groupByRaw($groupBy)
            ->get()
            ->mapWithKeys(fn ($row): array => [(int) $row->yr.'-'.(int) $row->mo => (int) $row->total])
            ->toArray();
    }

    /**
     * @return array{0: string, 1: string}
     */
    private function yearMonthSql(string $column): array
    {
        return match (DB::connection()->getDriverName()) {
            'pgsql' => [
                "EXTRACT(YEAR FROM {$column})::int as yr, EXTRACT(MONTH FROM {$column})::int as mo",
                "EXTRACT(YEAR FROM {$column})::int, EXTRACT(MONTH FROM {$column})::int",
            ],
            'sqlite' => [
                "CAST(strftime('%Y', {$column}) AS INTEGER) as yr, CAST(strftime('%m', {$column}) AS INTEGER) as mo",
                "strftime('%Y', {$column}), strftime('%m', {$column})",
            ],
            default => [
                "YEAR({$column}) as yr, MONTH({$column}) as mo",
                "YEAR({$column}), MONTH({$column})",
            ],
        };
    }

    /**
     * @return array<string, mixed>
     */
    private function studentViewData(?Student $student): array
    {
        if (! $student) {
            return [
                'mode'            => 'student',
                'student'         => null,
                'courses'         => collect(),
                'lessons'         => collect(),
                'assignments'     => collect(),
                'attendance'      => collect(),
                'grades'          => collect(),
                'progress'        => collect(),
                'progressByCourse'=> collect(),
            ];
        }

        $courseQuery = Course::query()->enrolledByStudent($student);
        $courseIds = (clone $courseQuery)->pluck('course_id');
        $progressByCourse = StudentProgress::query()
            ->where('student_id', $student->student_id)
            ->whereIn('course_id', $courseIds)
            ->get()
            ->keyBy('course_id');

        return [
            'mode'             => 'student',
            'student'          => $student->load(['department', 'academicYear', 'semester']),
            'courses'          => (clone $courseQuery)
                ->with(['courseAssignments.teacher'])
                ->withCount(['contentLessons as lessons_count' => fn (Builder $query): Builder => $query->publishedForStudents()])
                ->orderBy('course_name')
                ->get(),
            'lessons'          => ContentLesson::query()
                ->whereIn('course_id', $courseIds)
                ->publishedForStudents()
                ->with('course')
                ->orderBy('course_id')
                ->orderBy('position')
                ->limit(12)
                ->get(),
            'assignments'      => ContentAssignment::query()
                ->where('is_published', true)
                ->whereHas('lesson', fn (Builder $query): Builder => $query->whereIn('course_id', $courseIds))
                ->with('lesson.course')
                ->orderBy('due_at')
                ->limit(10)
                ->get(),
            'attendance'       => Attendance::query()
                ->where('student_id', $student->student_id)
                ->latest('attendance_date')
                ->limit(10)
                ->get(),
            'grades'           => AssessmentGrade::query()
                ->where('student_id', $student->student_id)
                ->latest('graded_at')
                ->limit(10)
                ->get(),
            'progress'         => StudentProgress::query()
                ->where('student_id', $student->student_id)
                ->whereIn('course_id', $courseIds)
                ->with('course')
                ->latest('progress_date')
                ->get(),
            'progressByCourse' => $progressByCourse,
        ];
    }
}
