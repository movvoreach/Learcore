<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('content_lessons', function (Blueprint $table) {
            $table->bigIncrements('content_lesson_id');
            $table->unsignedBigInteger('course_id');
            $table->unsignedInteger('module_number')->default(1);
            $table->string('module_title')->nullable();
            $table->string('title');
            $table->string('slug')->unique();
            $table->enum('content_type', [
                'lesson',
                'page',
                'video',
                'file',
                'url',
                'assignment',
                'quiz',
                'forum',
            ])->default('lesson');
            $table->text('summary')->nullable();
            $table->longText('body')->nullable();
            $table->string('external_url')->nullable();
            $table->string('file_path')->nullable();
            $table->string('video_url')->nullable();
            $table->unsignedInteger('duration_minutes')->nullable();
            $table->unsignedInteger('position')->default(1);
            $table->dateTime('available_from')->nullable();
            $table->dateTime('available_until')->nullable();
            $table->boolean('completion_required')->default(false);
            $table->enum('visibility', ['visible', 'hidden', 'scheduled'])->default('visible');
            $table->decimal('max_score', 8, 2)->nullable();
            $table->decimal('passing_score', 8, 2)->nullable();
            $table->boolean('allow_comments')->default(false);
            $table->json('metadata')->nullable();
            $table->boolean('is_published')->default(true);
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('course_id')
                ->references('course_id')
                ->on('courses')
                ->cascadeOnUpdate()
                ->restrictOnDelete();

            $table->index(['course_id', 'module_number', 'position']);
            $table->index(['content_type', 'visibility', 'is_published']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('content_lessons');
    }
};
