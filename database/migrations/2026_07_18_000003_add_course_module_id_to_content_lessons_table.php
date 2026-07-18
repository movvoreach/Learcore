<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasTable('content_lessons') || ! Schema::hasTable('course_modules')) {
            return;
        }

        if (! Schema::hasColumn('content_lessons', 'course_module_id')) {
            Schema::table('content_lessons', function (Blueprint $table): void {
                $table->unsignedBigInteger('course_module_id')->nullable()->after('course_id');
            });
        }

        $modules = DB::table('course_modules')->get();

        foreach ($modules as $module) {
            DB::table('content_lessons')
                ->where('course_id', $module->course_id)
                ->where('module_number', $module->module_number)
                ->whereNull('course_module_id')
                ->update(['course_module_id' => $module->course_module_id]);
        }

        Schema::table('content_lessons', function (Blueprint $table): void {
            $table->foreign('course_module_id')
                ->references('course_module_id')
                ->on('course_modules')
                ->cascadeOnUpdate()
                ->nullOnDelete();

            $table->index(['course_module_id', 'position'], 'lessons_module_position_idx');
        });
    }

    public function down(): void
    {
        if (! Schema::hasTable('content_lessons') || ! Schema::hasColumn('content_lessons', 'course_module_id')) {
            return;
        }

        Schema::table('content_lessons', function (Blueprint $table): void {
            $table->dropForeign(['course_module_id']);
            $table->dropIndex('lessons_module_position_idx');
            $table->dropColumn('course_module_id');
        });
    }
};
