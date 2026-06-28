<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('subjects', function (Blueprint $table) {
            $table->bigIncrements('subject_id');
            $table->unsignedBigInteger('course_id');
            $table->string('subject_code', 30)->unique();
            $table->string('subject_name', 150);
            $table->unsignedSmallInteger('credit')->default(0);
            $table->text('description')->nullable();
            $table->timestamps();

            $table->foreign('course_id')
                ->references('course_id')
                ->on('courses')
                ->cascadeOnUpdate()
                ->restrictOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('subjects');
    }
};
