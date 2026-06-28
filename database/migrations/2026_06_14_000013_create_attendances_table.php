<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('attendances', function (Blueprint $table) {
            $table->bigIncrements('attendance_id');
            $table->unsignedBigInteger('student_id');
            $table->unsignedBigInteger('class_room_id')->nullable();
            $table->date('attendance_date');
            $table->string('status', 30)->default('present');
            $table->text('note')->nullable();
            $table->timestamps();

            $table->foreign('student_id')->references('student_id')->on('students')->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreign('class_room_id')->references('class_room_id')->on('class_rooms')->cascadeOnUpdate()->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('attendances');
    }
};
