<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('teacher_schedules', function (Blueprint $table) {
            $table->bigIncrements('teacher_schedule_id');
            $table->unsignedBigInteger('teacher_id');
            $table->unsignedBigInteger('course_id')->nullable();
            $table->unsignedBigInteger('class_room_id')->nullable();
            $table->string('day_of_week', 20);
            $table->time('start_time');
            $table->time('end_time');
            $table->string('room', 100)->nullable();
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
                ->nullOnDelete();

            $table->foreign('class_room_id')
                ->references('class_room_id')
                ->on('class_rooms')
                ->cascadeOnUpdate()
                ->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('teacher_schedules');
    }
};
