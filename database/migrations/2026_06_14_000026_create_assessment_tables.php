<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('quizzes', function (Blueprint $table) {
            $table->bigIncrements('quiz_id');
            $table->unsignedBigInteger('content_lesson_id')->nullable();
            $table->string('title', 180);
            $table->longText('instructions')->nullable();
            $table->dateTime('available_from')->nullable();
            $table->dateTime('available_until')->nullable();
            $table->unsignedSmallInteger('time_limit_minutes')->nullable();
            $table->unsignedSmallInteger('max_attempts')->default(1);
            $table->decimal('passing_score', 6, 2)->default(50);
            $table->boolean('is_published')->default(false);
            $table->timestamps();

            $table->foreign('content_lesson_id')->references('content_lesson_id')->on('content_lessons')->cascadeOnUpdate()->nullOnDelete();
        });

        Schema::create('question_banks', function (Blueprint $table) {
            $table->bigIncrements('question_bank_id');
            $table->unsignedBigInteger('course_id')->nullable();
            $table->unsignedBigInteger('subject_id')->nullable();
            $table->string('title', 180);
            $table->text('description')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            $table->foreign('course_id')->references('course_id')->on('courses')->cascadeOnUpdate()->nullOnDelete();
            $table->foreign('subject_id')->references('subject_id')->on('subjects')->cascadeOnUpdate()->nullOnDelete();
        });

        Schema::create('assessment_questions', function (Blueprint $table) {
            $table->bigIncrements('assessment_question_id');
            $table->unsignedBigInteger('question_bank_id')->nullable();
            $table->unsignedBigInteger('content_lesson_id')->nullable();
            $table->longText('question_text');
            $table->string('question_type', 40)->default('multiple_choice');
            $table->decimal('points', 6, 2)->default(1);
            $table->longText('correct_answer')->nullable();
            $table->longText('explanation')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            $table->foreign('question_bank_id')->references('question_bank_id')->on('question_banks')->cascadeOnUpdate()->nullOnDelete();
            $table->foreign('content_lesson_id')->references('content_lesson_id')->on('content_lessons')->cascadeOnUpdate()->nullOnDelete();
        });

        Schema::create('question_options', function (Blueprint $table) {
            $table->bigIncrements('question_option_id');
            $table->unsignedBigInteger('assessment_question_id');
            $table->string('option_text', 500);
            $table->boolean('is_correct')->default(false);
            $table->unsignedSmallInteger('sort_order')->default(0);
            $table->timestamps();

            $table->foreign('assessment_question_id')->references('assessment_question_id')->on('assessment_questions')->cascadeOnUpdate()->cascadeOnDelete();
        });

        Schema::create('exams', function (Blueprint $table) {
            $table->bigIncrements('exam_id');
            $table->unsignedBigInteger('course_id')->nullable();
            $table->unsignedBigInteger('subject_id')->nullable();
            $table->string('title', 180);
            $table->text('description')->nullable();
            $table->date('exam_date')->nullable();
            $table->time('start_time')->nullable();
            $table->time('end_time')->nullable();
            $table->unsignedSmallInteger('duration_minutes')->nullable();
            $table->decimal('total_score', 6, 2)->default(100);
            $table->decimal('passing_score', 6, 2)->default(50);
            $table->string('status', 30)->default('draft');
            $table->timestamps();

            $table->foreign('course_id')->references('course_id')->on('courses')->cascadeOnUpdate()->nullOnDelete();
            $table->foreign('subject_id')->references('subject_id')->on('subjects')->cascadeOnUpdate()->nullOnDelete();
        });

        Schema::create('exam_candidates', function (Blueprint $table) {
            $table->bigIncrements('exam_candidate_id');
            $table->unsignedBigInteger('exam_id');
            $table->unsignedBigInteger('student_id');
            $table->string('seat_number', 50)->nullable();
            $table->string('status', 30)->default('registered');
            $table->timestamps();

            $table->foreign('exam_id')->references('exam_id')->on('exams')->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreign('student_id')->references('student_id')->on('students')->cascadeOnUpdate()->cascadeOnDelete();
            $table->unique(['exam_id', 'student_id']);
        });

        Schema::create('exam_submissions', function (Blueprint $table) {
            $table->bigIncrements('exam_submission_id');
            $table->unsignedBigInteger('exam_id');
            $table->unsignedBigInteger('student_id');
            $table->dateTime('submitted_at')->nullable();
            $table->unsignedSmallInteger('attempt_no')->default(1);
            $table->json('answers')->nullable();
            $table->decimal('score', 6, 2)->nullable();
            $table->string('status', 30)->default('submitted');
            $table->longText('feedback')->nullable();
            $table->timestamps();

            $table->foreign('exam_id')->references('exam_id')->on('exams')->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreign('student_id')->references('student_id')->on('students')->cascadeOnUpdate()->cascadeOnDelete();
        });

        Schema::create('assessment_grades', function (Blueprint $table) {
            $table->bigIncrements('assessment_grade_id');
            $table->unsignedBigInteger('student_id');
            $table->unsignedBigInteger('exam_id')->nullable();
            $table->unsignedBigInteger('quiz_id')->nullable();
            $table->unsignedBigInteger('content_assignment_id')->nullable();
            $table->unsignedBigInteger('graded_by')->nullable();
            $table->decimal('score', 6, 2)->default(0);
            $table->decimal('max_score', 6, 2)->default(100);
            $table->string('grade', 20)->nullable();
            $table->dateTime('graded_at')->nullable();
            $table->text('remarks')->nullable();
            $table->timestamps();

            $table->foreign('student_id')->references('student_id')->on('students')->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreign('exam_id')->references('exam_id')->on('exams')->cascadeOnUpdate()->nullOnDelete();
            $table->foreign('quiz_id')->references('quiz_id')->on('quizzes')->cascadeOnUpdate()->nullOnDelete();
            $table->foreign('content_assignment_id')->references('content_assignment_id')->on('content_assignments')->cascadeOnUpdate()->nullOnDelete();
            $table->foreign('graded_by')->references('id')->on('users')->cascadeOnUpdate()->nullOnDelete();
        });

        Schema::create('assessment_results', function (Blueprint $table) {
            $table->bigIncrements('assessment_result_id');
            $table->unsignedBigInteger('student_id');
            $table->unsignedBigInteger('exam_id')->nullable();
            $table->unsignedBigInteger('quiz_id')->nullable();
            $table->string('assessment_type', 30)->default('exam');
            $table->decimal('total_score', 6, 2)->default(0);
            $table->boolean('passed')->default(false);
            $table->unsignedInteger('rank')->nullable();
            $table->dateTime('published_at')->nullable();
            $table->text('remarks')->nullable();
            $table->timestamps();

            $table->foreign('student_id')->references('student_id')->on('students')->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreign('exam_id')->references('exam_id')->on('exams')->cascadeOnUpdate()->nullOnDelete();
            $table->foreign('quiz_id')->references('quiz_id')->on('quizzes')->cascadeOnUpdate()->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('assessment_results');
        Schema::dropIfExists('assessment_grades');
        Schema::dropIfExists('exam_submissions');
        Schema::dropIfExists('exam_candidates');
        Schema::dropIfExists('exams');
        Schema::dropIfExists('question_options');
        Schema::dropIfExists('assessment_questions');
        Schema::dropIfExists('question_banks');
        Schema::dropIfExists('quizzes');
    }
};
