<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('certificates', function (Blueprint $table): void {
            $table->foreignId('course_completion_request_id')
                ->nullable()
                ->after('course_id')
                ->constrained('course_completion_requests')
                ->nullOnDelete()
                ->cascadeOnUpdate();

            $table->unsignedBigInteger('issued_by')->nullable()->after('issued_date');
            $table->timestamp('issued_at')->nullable()->after('issued_by');

            $table->foreign('issued_by')->references('id')->on('users')->cascadeOnUpdate()->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('certificates', function (Blueprint $table): void {
            $table->dropForeign(['issued_by']);
            $table->dropForeign(['course_completion_request_id']);
            $table->dropColumn(['course_completion_request_id', 'issued_by', 'issued_at']);
        });
    }
};
