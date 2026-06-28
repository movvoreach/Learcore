<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('content_lessons', function (Blueprint $table): void {
            if (! Schema::hasColumn('content_lessons', 'module_number')) {
                $table->unsignedInteger('module_number')->default(1);
            }

            if (! Schema::hasColumn('content_lessons', 'module_title')) {
                $table->string('module_title')->nullable();
            }

            if (! Schema::hasColumn('content_lessons', 'slug')) {
                $table->string('slug')->nullable();
            }

            if (! Schema::hasColumn('content_lessons', 'content_type')) {
                $table->string('content_type', 30)->default('lesson');
            }

            if (! Schema::hasColumn('content_lessons', 'body')) {
                $table->longText('body')->nullable();
            }

            if (! Schema::hasColumn('content_lessons', 'external_url')) {
                $table->string('external_url')->nullable();
            }

            if (! Schema::hasColumn('content_lessons', 'file_path')) {
                $table->string('file_path')->nullable();
            }

            if (! Schema::hasColumn('content_lessons', 'video_url')) {
                $table->string('video_url')->nullable();
            }

            if (! Schema::hasColumn('content_lessons', 'duration_minutes')) {
                $table->unsignedInteger('duration_minutes')->nullable();
            }

            if (! Schema::hasColumn('content_lessons', 'position')) {
                $table->unsignedInteger('position')->default(1);
            }

            if (! Schema::hasColumn('content_lessons', 'completion_required')) {
                $table->boolean('completion_required')->default(false);
            }

            if (! Schema::hasColumn('content_lessons', 'max_score')) {
                $table->decimal('max_score', 8, 2)->nullable();
            }

            if (! Schema::hasColumn('content_lessons', 'passing_score')) {
                $table->decimal('passing_score', 8, 2)->nullable();
            }

            if (! Schema::hasColumn('content_lessons', 'allow_comments')) {
                $table->boolean('allow_comments')->default(false);
            }

            if (! Schema::hasColumn('content_lessons', 'metadata')) {
                $table->json('metadata')->nullable();
            }
        });

        if (Schema::hasColumn('content_lessons', 'content') && Schema::hasColumn('content_lessons', 'body')) {
            DB::table('content_lessons')
                ->whereNull('body')
                ->update(['body' => DB::raw('content')]);
        }

        if (Schema::hasColumn('content_lessons', 'sort_order') && Schema::hasColumn('content_lessons', 'position')) {
            DB::table('content_lessons')
                ->whereNotNull('sort_order')
                ->update(['position' => DB::raw('sort_order')]);
        }

        if (Schema::hasColumn('content_lessons', 'slug')) {
            DB::table('content_lessons')
                ->whereNull('slug')
                ->update(['slug' => DB::raw("concat('lesson-', content_lesson_id)")]);
        }
    }

    public function down(): void
    {
        Schema::table('content_lessons', function (Blueprint $table): void {
            foreach ([
                'metadata',
                'allow_comments',
                'passing_score',
                'max_score',
                'completion_required',
                'position',
                'duration_minutes',
                'video_url',
                'file_path',
                'external_url',
                'body',
                'content_type',
                'slug',
                'module_title',
                'module_number',
            ] as $column) {
                if (Schema::hasColumn('content_lessons', $column)) {
                    $table->dropColumn($column);
                }
            }
        });
    }
};
