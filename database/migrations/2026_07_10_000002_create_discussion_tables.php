<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('discussion_posts', function (Blueprint $table) {
            $table->bigIncrements('discussion_post_id');
            $table->unsignedBigInteger('course_id');
            $table->unsignedBigInteger('content_lesson_id')->nullable();
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->string('title', 180)->nullable();
            $table->longText('body');
            $table->string('image_path')->nullable();
            $table->enum('status', ['published', 'hidden'])->default('published')->index();
            $table->boolean('is_pinned')->default(false)->index();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('course_id')
                ->references('course_id')
                ->on('courses')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();

            $table->foreign('content_lesson_id')
                ->references('content_lesson_id')
                ->on('content_lessons')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();

            $table->index(['course_id', 'status', 'is_pinned']);
            $table->index(['content_lesson_id', 'status']);
        });

        Schema::create('discussion_comments', function (Blueprint $table) {
            $table->bigIncrements('discussion_comment_id');
            $table->unsignedBigInteger('discussion_post_id');
            $table->unsignedBigInteger('parent_comment_id')->nullable();
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->longText('body');
            $table->string('image_path')->nullable();
            $table->enum('status', ['published', 'hidden'])->default('published')->index();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('discussion_post_id')
                ->references('discussion_post_id')
                ->on('discussion_posts')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();

            $table->foreign('parent_comment_id')
                ->references('discussion_comment_id')
                ->on('discussion_comments')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();

            $table->index(['discussion_post_id', 'status']);
            $table->index(['parent_comment_id', 'status']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('discussion_comments');
        Schema::dropIfExists('discussion_posts');
    }
};
