<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('students', function (Blueprint $table) {
            $table->unsignedBigInteger('department_id')->nullable()->after('student_code');
            $table->unsignedBigInteger('academic_year_id')->nullable()->after('department_id');
            $table->unsignedBigInteger('semester_id')->nullable()->after('academic_year_id');

            $table->foreign('department_id')
                ->references('department_id')
                ->on('departments')
                ->cascadeOnUpdate()
                ->nullOnDelete();

            $table->foreign('academic_year_id')
                ->references('academic_year_id')
                ->on('academic_years')
                ->cascadeOnUpdate()
                ->nullOnDelete();

            $table->foreign('semester_id')
                ->references('semester_id')
                ->on('semesters')
                ->cascadeOnUpdate()
                ->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('students', function (Blueprint $table) {
            $table->dropForeign(['department_id']);
            $table->dropForeign(['academic_year_id']);
            $table->dropForeign(['semester_id']);
            $table->dropColumn(['department_id', 'academic_year_id', 'semester_id']);
        });
    }
};
