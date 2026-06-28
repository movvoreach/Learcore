<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('content_chapters', function (Blueprint $table) {
            $table->bigIncrements('content_chapter_id');
            $table->unsignedBigInteger('content_lesson_id');
            $table->string('title', 180);
            $table->text('summary')->nullable();
            $table->longText('content')->nullable();
            $table->unsignedInteger('sort_order')->default(0);
            $table->boolean('is_published')->default(false);
            $table->timestamps();

            $table->foreign('content_lesson_id')
                ->references('content_lesson_id')
                ->on('content_lessons')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('content_chapters');
    }
};
