<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('courses', function (Blueprint $table) {
            $table->bigIncrements('course_id');
            $table->unsignedBigInteger('course_category_id');
            $table->string('course_code', 30)->unique();
            $table->string('course_name', 150);
            $table->text('description')->nullable();
            $table->timestamps();

            $table->foreign('course_category_id')
                ->references('course_category_id')
                ->on('course_categories')
                ->cascadeOnUpdate()
                ->restrictOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('courses');
    }
};
