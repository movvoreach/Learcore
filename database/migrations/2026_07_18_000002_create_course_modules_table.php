<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasTable('course_modules')) {
            Schema::create('course_modules', function (Blueprint $table): void {
                $table->bigIncrements('course_module_id');
                $table->unsignedBigInteger('course_id');
                $table->unsignedInteger('module_number');
                $table->string('title');
                $table->text('description')->nullable();
                $table->timestamps();

                $table->foreign('course_id')
                    ->references('course_id')
                    ->on('courses')
                    ->cascadeOnUpdate()
                    ->cascadeOnDelete();

                $table->unique(['course_id', 'module_number']);
                $table->index(['course_id', 'title']);
            });
        }

        if (Schema::hasTable('content_lessons')) {
            $groups = DB::table('content_lessons')
                ->select('course_id', 'module_number', 'module_title')
                ->whereNotNull('course_id')
                ->groupBy('course_id', 'module_number', 'module_title')
                ->orderBy('course_id')
                ->orderBy('module_number')
                ->get();

            foreach ($groups as $group) {
                $moduleNumber = (int) ($group->module_number ?: 1);

                DB::table('course_modules')->updateOrInsert(
                    [
                        'course_id' => $group->course_id,
                        'module_number' => $moduleNumber,
                    ],
                    [
                        'title' => $group->module_title ?: 'Course Module '.$moduleNumber,
                        'updated_at' => now(),
                        'created_at' => now(),
                    ],
                );
            }
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('course_modules');
    }
};
