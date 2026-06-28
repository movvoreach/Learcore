<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('student_promotions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('student_id');
            $table->unsignedBigInteger('from_department_id')->nullable();
            $table->unsignedBigInteger('from_year_id')->nullable();
            $table->unsignedBigInteger('from_semester_id')->nullable();
            $table->unsignedBigInteger('to_year_id');
            $table->unsignedBigInteger('to_semester_id');
            $table->timestamp('promoted_at');
            $table->timestamps();

            $table->foreign('student_id')->references('student_id')->on('students')->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreign('from_department_id')->references('department_id')->on('departments')->cascadeOnUpdate()->nullOnDelete();
            $table->foreign('from_year_id')->references('academic_year_id')->on('academic_years')->cascadeOnUpdate()->nullOnDelete();
            $table->foreign('from_semester_id')->references('semester_id')->on('semesters')->cascadeOnUpdate()->nullOnDelete();
            $table->foreign('to_year_id')->references('academic_year_id')->on('academic_years')->cascadeOnUpdate()->restrictOnDelete();
            $table->foreign('to_semester_id')->references('semester_id')->on('semesters')->cascadeOnUpdate()->restrictOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('student_promotions');
    }
};
