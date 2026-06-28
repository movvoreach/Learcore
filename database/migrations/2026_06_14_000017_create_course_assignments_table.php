<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('course_assignments', function (Blueprint $table) {
            $table->bigIncrements('course_assignment_id');
            $table->unsignedBigInteger('teacher_id');
            $table->unsignedBigInteger('course_id');
            $table->unsignedBigInteger('class_room_id')->nullable();
            $table->unsignedBigInteger('academic_year_id')->nullable();
            $table->date('assigned_date')->nullable();
            $table->string('status', 30)->default('active');
            $table->text('note')->nullable();
            $table->timestamps();

            $table->foreign('teacher_id')
                ->references('teacher_id')
                ->on('teachers')
                ->cascadeOnUpdate()
                ->restrictOnDelete();

            $table->foreign('course_id')
                ->references('course_id')
                ->on('courses')
                ->cascadeOnUpdate()
                ->restrictOnDelete();

            $table->foreign('class_room_id')
                ->references('class_room_id')
                ->on('class_rooms')
                ->cascadeOnUpdate()
                ->nullOnDelete();

            $table->foreign('academic_year_id')
                ->references('academic_year_id')
                ->on('academic_years')
                ->cascadeOnUpdate()
                ->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('course_assignments');
    }
};
