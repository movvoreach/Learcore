<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('student_progresses', function (Blueprint $table): void {
            $table->decimal('attendance_score', 6, 2)->default(0)->after('score');
            $table->decimal('attribute_score', 6, 2)->default(0)->after('attendance_score');
            $table->decimal('midterm_score', 6, 2)->default(0)->after('attribute_score');
            $table->decimal('assignment_score', 6, 2)->default(0)->after('midterm_score');
            $table->decimal('final_score', 6, 2)->default(0)->after('assignment_score');
        });
    }

    public function down(): void
    {
        Schema::table('student_progresses', function (Blueprint $table): void {
            $table->dropColumn([
                'attendance_score',
                'attribute_score',
                'midterm_score',
                'assignment_score',
                'final_score',
            ]);
        });
    }
};
