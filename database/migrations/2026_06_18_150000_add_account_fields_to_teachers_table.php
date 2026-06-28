<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('teachers', function (Blueprint $table) {
            $table->foreignId('user_id')
                ->nullable()
                ->unique()
                ->after('teacher_id')
                ->constrained()
                ->nullOnDelete();

            $table->unsignedBigInteger('department_id')->nullable()->after('user_id');
            $table->string('employment_type', 30)->default('full_time')->after('department_id');

            $table->foreign('department_id')
                ->references('department_id')
                ->on('departments')
                ->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('teachers', function (Blueprint $table) {
            $table->dropForeign(['department_id']);
            $table->dropConstrainedForeignId('user_id');
            $table->dropColumn(['department_id', 'employment_type']);
        });
    }
};
