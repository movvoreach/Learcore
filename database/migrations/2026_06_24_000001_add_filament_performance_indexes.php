<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('courses', function (Blueprint $table): void {
            $table->index(['department_id', 'academic_year_id', 'semester_id'], 'courses_academic_scope_idx');
            $table->index(['course_category_id', 'department_id'], 'courses_category_department_idx');
        });

        Schema::table('students', function (Blueprint $table): void {
            $table->index(['department_id', 'academic_year_id', 'semester_id', 'status'], 'students_academic_status_idx');
            $table->index(['first_name', 'last_name'], 'students_name_idx');
        });

        Schema::table('content_lessons', function (Blueprint $table): void {
            $table->index(['course_id', 'is_published', 'visibility', 'module_number', 'position'], 'lessons_course_visible_order_idx');
            $table->index(['course_id', 'is_published', 'available_from', 'available_until'], 'lessons_course_schedule_idx');
        });

        Schema::table('content_chapters', function (Blueprint $table): void {
            $table->index(['content_lesson_id', 'is_published', 'sort_order'], 'chapters_lesson_published_order_idx');
        });

        Schema::table('content_videos', function (Blueprint $table): void {
            $table->index(['content_lesson_id', 'is_published', 'sort_order'], 'videos_lesson_published_order_idx');
            $table->index(['content_chapter_id', 'is_published', 'sort_order'], 'videos_chapter_published_order_idx');
        });

        Schema::table('content_documents', function (Blueprint $table): void {
            $table->index(['content_lesson_id', 'is_published', 'sort_order'], 'documents_lesson_published_order_idx');
            $table->index(['content_chapter_id', 'is_published', 'sort_order'], 'documents_chapter_published_order_idx');
        });

        Schema::table('content_resources', function (Blueprint $table): void {
            $table->index(['content_lesson_id', 'is_published', 'sort_order'], 'resources_lesson_published_order_idx');
            $table->index(['content_chapter_id', 'is_published', 'sort_order'], 'resources_chapter_published_order_idx');
        });

        Schema::table('content_assignments', function (Blueprint $table): void {
            $table->index(['content_lesson_id', 'is_published', 'due_at'], 'assignments_lesson_published_due_idx');
            $table->index(['content_chapter_id', 'is_published', 'due_at'], 'assignments_chapter_published_due_idx');
        });

        Schema::table('quizzes', function (Blueprint $table): void {
            $table->index(['content_lesson_id', 'is_published', 'available_from'], 'quizzes_lesson_published_from_idx');
        });

        Schema::table('student_progresses', function (Blueprint $table): void {
            $table->index(['student_id', 'course_id'], 'progress_student_course_idx');
            $table->index(['course_id', 'progress_date'], 'progress_course_date_idx');
        });

        Schema::table('assessment_questions', function (Blueprint $table): void {
            $table->index(['content_lesson_id', 'is_active'], 'questions_lesson_active_idx');
            $table->index(['question_bank_id', 'is_active'], 'questions_bank_active_idx');
        });

        Schema::table('question_options', function (Blueprint $table): void {
            $table->index(['assessment_question_id', 'sort_order'], 'options_question_order_idx');
        });

        Schema::table('assessment_grades', function (Blueprint $table): void {
            $table->index(['student_id', 'graded_at'], 'grades_student_graded_idx');
            $table->index(['student_id', 'exam_id'], 'grades_student_exam_idx');
            $table->index(['student_id', 'quiz_id'], 'grades_student_quiz_idx');
            $table->index(['student_id', 'content_assignment_id'], 'grades_student_assignment_idx');
        });

        Schema::table('assessment_results', function (Blueprint $table): void {
            $table->index(['student_id', 'quiz_id'], 'results_student_quiz_idx');
            $table->index(['student_id', 'published_at'], 'results_student_published_idx');
        });

        Schema::table('assignment_submissions', function (Blueprint $table): void {
            $table->index(['student_id', 'content_assignment_id'], 'submissions_student_assignment_idx');
            $table->index(['student_id', 'submitted_at'], 'submissions_student_submitted_idx');
        });

        Schema::table('course_assignments', function (Blueprint $table): void {
            $table->index(['course_id', 'teacher_id'], 'course_assignments_course_teacher_idx');
            $table->index(['teacher_id', 'course_id'], 'course_assignments_teacher_course_idx');
        });

        Schema::table('enrollments', function (Blueprint $table): void {
            $table->index(['student_id', 'course_id', 'semester_id'], 'enrollments_student_course_semester_idx');
            $table->index(['course_id', 'academic_year_id', 'semester_id', 'status'], 'enrollments_course_period_status_idx');
        });

        Schema::table('attendances', function (Blueprint $table): void {
            $table->index(['student_id', 'attendance_date'], 'attendances_student_date_idx');
            $table->index(['class_room_id', 'attendance_date'], 'attendances_class_date_idx');
        });

        Schema::table('certificates', function (Blueprint $table): void {
            $table->index(['student_id', 'issued_date'], 'certificates_student_issued_idx');
            $table->index(['course_id', 'issued_date'], 'certificates_course_issued_idx');
        });
    }

    public function down(): void
    {
        Schema::table('courses', function (Blueprint $table): void {
            $table->dropIndex('courses_academic_scope_idx');
            $table->dropIndex('courses_category_department_idx');
        });

        Schema::table('students', function (Blueprint $table): void {
            $table->dropIndex('students_academic_status_idx');
            $table->dropIndex('students_name_idx');
        });

        Schema::table('content_lessons', function (Blueprint $table): void {
            $table->dropIndex('lessons_course_visible_order_idx');
            $table->dropIndex('lessons_course_schedule_idx');
        });

        Schema::table('content_chapters', fn (Blueprint $table) => $table->dropIndex('chapters_lesson_published_order_idx'));
        Schema::table('content_videos', function (Blueprint $table): void {
            $table->dropIndex('videos_lesson_published_order_idx');
            $table->dropIndex('videos_chapter_published_order_idx');
        });
        Schema::table('content_documents', function (Blueprint $table): void {
            $table->dropIndex('documents_lesson_published_order_idx');
            $table->dropIndex('documents_chapter_published_order_idx');
        });
        Schema::table('content_resources', function (Blueprint $table): void {
            $table->dropIndex('resources_lesson_published_order_idx');
            $table->dropIndex('resources_chapter_published_order_idx');
        });
        Schema::table('content_assignments', function (Blueprint $table): void {
            $table->dropIndex('assignments_lesson_published_due_idx');
            $table->dropIndex('assignments_chapter_published_due_idx');
        });
        Schema::table('quizzes', fn (Blueprint $table) => $table->dropIndex('quizzes_lesson_published_from_idx'));
        Schema::table('student_progresses', function (Blueprint $table): void {
            $table->dropIndex('progress_student_course_idx');
            $table->dropIndex('progress_course_date_idx');
        });
        Schema::table('assessment_questions', function (Blueprint $table): void {
            $table->dropIndex('questions_lesson_active_idx');
            $table->dropIndex('questions_bank_active_idx');
        });
        Schema::table('question_options', fn (Blueprint $table) => $table->dropIndex('options_question_order_idx'));
        Schema::table('assessment_grades', function (Blueprint $table): void {
            $table->dropIndex('grades_student_graded_idx');
            $table->dropIndex('grades_student_exam_idx');
            $table->dropIndex('grades_student_quiz_idx');
            $table->dropIndex('grades_student_assignment_idx');
        });
        Schema::table('assessment_results', function (Blueprint $table): void {
            $table->dropIndex('results_student_quiz_idx');
            $table->dropIndex('results_student_published_idx');
        });
        Schema::table('assignment_submissions', function (Blueprint $table): void {
            $table->dropIndex('submissions_student_assignment_idx');
            $table->dropIndex('submissions_student_submitted_idx');
        });
        Schema::table('course_assignments', function (Blueprint $table): void {
            $table->dropIndex('course_assignments_course_teacher_idx');
            $table->dropIndex('course_assignments_teacher_course_idx');
        });
        Schema::table('enrollments', function (Blueprint $table): void {
            $table->dropIndex('enrollments_student_course_semester_idx');
            $table->dropIndex('enrollments_course_period_status_idx');
        });
        Schema::table('attendances', function (Blueprint $table): void {
            $table->dropIndex('attendances_student_date_idx');
            $table->dropIndex('attendances_class_date_idx');
        });
        Schema::table('certificates', function (Blueprint $table): void {
            $table->dropIndex('certificates_student_issued_idx');
            $table->dropIndex('certificates_course_issued_idx');
        });
    }
};
