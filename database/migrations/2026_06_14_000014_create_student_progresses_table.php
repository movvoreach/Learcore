<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('student_progresses', function (Blueprint $table) {
            $table->bigIncrements('progress_id');
            $table->unsignedBigInteger('student_id');
            $table->unsignedBigInteger('course_id')->nullable();
            $table->unsignedBigInteger('class_room_id')->nullable();
            $table->date('progress_date')->nullable();
            $table->decimal('progress_percent', 5, 2)->default(0);
            $table->decimal('score', 6, 2)->nullable();
            $table->string('status', 30)->default('in_progress');
            $table->text('note')->nullable();
            $table->timestamps();

            $table->foreign('student_id')->references('student_id')->on('students')->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreign('course_id')->references('course_id')->on('courses')->cascadeOnUpdate()->nullOnDelete();
            $table->foreign('class_room_id')->references('class_room_id')->on('class_rooms')->cascadeOnUpdate()->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('student_progresses');
    }
};
