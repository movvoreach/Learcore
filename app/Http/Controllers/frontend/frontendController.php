<?php

namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;
use Illuminate\Support\Str;
use App\Models\Course;

class frontendController extends Controller
{
    public function index()
    {
        $courses = Course::with(['category', 'instructor.user', 'academicYear'])
            ->withCount([
                'contentLessons as lessons_count',
                'enrollments as students_count',
            ])
            ->withSum('contentLessons as total_duration_minutes', 'duration_minutes')
            ->latest()
            ->paginate(12);

        return view('frontend.frontend', compact('courses'));
    }

    public function courses()
    {
        $courses = Course::with(['category', 'instructor.user', 'academicYear'])
            ->withCount([
                'contentLessons as lessons_count',
                'enrollments as students_count',
            ])
            ->withSum('contentLessons as total_duration_minutes', 'duration_minutes')
            ->latest()
            ->paginate(12);

        $categories = \App\Models\CourseCategory::whereHas('courses')->get();
        $academicYears = \App\Models\AcademicYear::whereHas('courses')->get();

        return view('frontend.courses', compact('courses', 'categories', 'academicYears'));
    }

    public function courseDetail(string $course = 'web-development')
    {
        $courseRecord = $this->resolveCourse($course);
        $lessons = $courseRecord?->contentLessons()
            ->publishedForStudents()
            ->orderBy('module_number')
            ->orderBy('position')
            ->get()
            ?? collect();

        return view('frontend.course-detail', [
            'course' => $course,
            'courseRecord' => $courseRecord,
            'lessons' => $lessons,
        ]);
    }

    public function lesson(string $course, string $lesson)
    {
        $courseRecord = $this->resolveCourse($course);
        $lessons = $courseRecord?->contentLessons()
            ->publishedForStudents()
            ->orderBy('module_number')
            ->orderBy('position')
            ->get()
            ?? collect();
        $lessonRecord = $lessons->firstWhere('slug', $lesson);
        $nextLesson = $lessonRecord
            ? $lessons->skipUntil(fn ($contentLesson) => $contentLesson->is($lessonRecord))->skip(1)->first()
            : null;

        return view('frontend.lesson', [
            'course' => $course,
            'courseRecord' => $courseRecord,
            'lessons' => $lessons,
            'lessonRecord' => $lessonRecord,
            'nextLesson' => $nextLesson,
            'lesson' => $lesson,
        ]);
    }

    private function resolveCourse(string $course): ?Course
    {
        $query = Course::with(['category', 'instructor.user', 'academicYear'])
            ->withCount([
                'contentLessons as lessons_count',
                'enrollments as students_count',
            ])
            ->withSum('contentLessons as total_duration_minutes', 'duration_minutes');

        if (is_numeric($course)) {
            return (clone $query)->find((int) $course);
        }

        if (preg_match('/-(\d+)$/', $course, $matches)) {
            return (clone $query)->find((int) $matches[1]);
        }

        $courseByCode = (clone $query)->where('course_code', $course)->first();

        if ($courseByCode) {
            return $courseByCode;
        }

        return (clone $query)
            ->get()
            ->first(fn (Course $courseRecord): bool => Str::slug($courseRecord->course_name) === Str::slug($course));
    }
}
