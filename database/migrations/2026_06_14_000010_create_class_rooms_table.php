<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('class_rooms', function (Blueprint $table) {
            $table->bigIncrements('class_room_id');
            $table->unsignedBigInteger('course_id');
            $table->unsignedBigInteger('academic_year_id')->nullable();
            $table->string('class_code', 30)->unique();
            $table->string('class_name', 150);
            $table->string('room', 100)->nullable();
            $table->timestamps();

            $table->foreign('course_id')
                ->references('course_id')
                ->on('courses')
                ->cascadeOnUpdate()
                ->restrictOnDelete();

            $table->foreign('academic_year_id')
                ->references('academic_year_id')
                ->on('academic_years')
                ->cascadeOnUpdate()
                ->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('class_rooms');
    }
};
