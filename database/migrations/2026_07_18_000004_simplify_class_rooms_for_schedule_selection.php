<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('class_rooms', function (Blueprint $table): void {
            if (! Schema::hasColumn('class_rooms', 'table')) {
                $table->string('table')->nullable()->after('class_name');
            }

            if (! Schema::hasColumn('class_rooms', 'status')) {
                $table->enum('status', ['active', 'inactive'])->default('active')->after('table');
            }
        });

        Schema::table('class_rooms', function (Blueprint $table): void {
            $table->dropForeign(['course_id']);
        });

        Schema::table('class_rooms', function (Blueprint $table): void {
            $table->unsignedBigInteger('course_id')->nullable()->change();

            $table->foreign('course_id')
                ->references('course_id')
                ->on('courses')
                ->cascadeOnUpdate()
                ->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('class_rooms', function (Blueprint $table): void {
            $table->dropForeign(['course_id']);
        });

        Schema::table('class_rooms', function (Blueprint $table): void {
            $table->unsignedBigInteger('course_id')->nullable(false)->change();

            $table->foreign('course_id')
                ->references('course_id')
                ->on('courses')
                ->cascadeOnUpdate()
                ->restrictOnDelete();

            if (Schema::hasColumn('class_rooms', 'status')) {
                $table->dropColumn('status');
            }

            if (Schema::hasColumn('class_rooms', 'table')) {
                $table->dropColumn('table');
            }
        });
    }
};
