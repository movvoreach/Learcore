<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('course_completion_requests', function (Blueprint $table): void {
            $table->id();
            $table->unsignedBigInteger('course_id');
            $table->unsignedBigInteger('teacher_id');
            $table->unsignedBigInteger('completed_by')->nullable();
            $table->timestamp('completed_at')->nullable();
            $table->string('status', 30)->default('pending');
            $table->unsignedBigInteger('approved_by')->nullable();
            $table->timestamp('approved_at')->nullable();
            $table->unsignedBigInteger('rejected_by')->nullable();
            $table->timestamp('rejected_at')->nullable();
            $table->text('rejection_reason')->nullable();
            $table->json('summary')->nullable();
            $table->timestamps();

            $table->foreign('course_id')->references('course_id')->on('courses')->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreign('teacher_id')->references('teacher_id')->on('teachers')->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreign('completed_by')->references('id')->on('users')->cascadeOnUpdate()->nullOnDelete();
            $table->foreign('approved_by')->references('id')->on('users')->cascadeOnUpdate()->nullOnDelete();
            $table->foreign('rejected_by')->references('id')->on('users')->cascadeOnUpdate()->nullOnDelete();

            $table->index(['status', 'completed_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('course_completion_requests');
    }
};
