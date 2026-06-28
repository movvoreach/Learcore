<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('certificates', function (Blueprint $table) {
            $table->bigIncrements('certificate_id');
            $table->unsignedBigInteger('student_id');
            $table->unsignedBigInteger('course_id')->nullable();
            $table->string('certificate_no', 50)->unique();
            $table->date('issued_date')->nullable();
            $table->string('status', 30)->default('issued');
            $table->text('note')->nullable();
            $table->timestamps();

            $table->foreign('student_id')->references('student_id')->on('students')->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreign('course_id')->references('course_id')->on('courses')->cascadeOnUpdate()->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('certificates');
    }
};
