<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('assignment_submissions', function (Blueprint $table) {
            $table->bigIncrements('assignment_submission_id');
            $table->unsignedBigInteger('content_assignment_id');
            $table->unsignedBigInteger('student_id');
            $table->longText('response')->nullable();
            $table->string('attachment_url', 1000)->nullable();
            $table->dateTime('submitted_at')->nullable();
            $table->string('status', 30)->default('submitted');
            $table->decimal('score', 6, 2)->nullable();
            $table->longText('feedback')->nullable();
            $table->timestamps();

            $table->foreign('content_assignment_id')
                ->references('content_assignment_id')
                ->on('content_assignments')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();

            $table->foreign('student_id')
                ->references('student_id')
                ->on('students')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('assignment_submissions');
    }
};
