<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('content_videos', function (Blueprint $table) {
            $table->bigIncrements('content_video_id');
            $table->unsignedBigInteger('content_lesson_id');
            $table->unsignedBigInteger('content_chapter_id')->nullable();
            $table->string('title', 180);
            $table->text('description')->nullable();
            $table->string('video_path')->nullable();
            $table->string('video_url')->nullable();
            $table->unsignedInteger('duration_seconds')->nullable();
            $table->unsignedInteger('sort_order')->default(0);
            $table->boolean('is_published')->default(false);
            $table->timestamps();

            $table->foreign('content_lesson_id')->references('content_lesson_id')->on('content_lessons')->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreign('content_chapter_id')->references('content_chapter_id')->on('content_chapters')->cascadeOnUpdate()->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('content_videos');
    }
};
