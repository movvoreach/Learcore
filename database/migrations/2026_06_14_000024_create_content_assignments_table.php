<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('content_assignments', function (Blueprint $table) {
            $table->bigIncrements('content_assignment_id');
            $table->unsignedBigInteger('content_lesson_id');
            $table->unsignedBigInteger('content_chapter_id')->nullable();
            $table->string('title', 180);
            $table->longText('instructions')->nullable();
            $table->string('attachment_path')->nullable();
            $table->dateTime('due_at')->nullable();
            $table->unsignedInteger('max_score')->default(100);
            $table->boolean('allow_late_submission')->default(false);
            $table->boolean('is_published')->default(false);
            $table->timestamps();

            $table->foreign('content_lesson_id')->references('content_lesson_id')->on('content_lessons')->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreign('content_chapter_id')->references('content_chapter_id')->on('content_chapters')->cascadeOnUpdate()->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('content_assignments');
    }
};
