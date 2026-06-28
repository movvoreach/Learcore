<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('content_lessons', function (Blueprint $table): void {
            if (! Schema::hasColumn('content_lessons', 'available_from')) {
                $table->dateTime('available_from')->nullable()->after('position');
            }

            if (! Schema::hasColumn('content_lessons', 'available_until')) {
                $table->dateTime('available_until')->nullable()->after('available_from');
            }

            if (! Schema::hasColumn('content_lessons', 'visibility')) {
                $table->string('visibility', 20)->default('visible')->after('completion_required');
            }
        });
    }

    public function down(): void
    {
        Schema::table('content_lessons', function (Blueprint $table): void {
            if (Schema::hasColumn('content_lessons', 'visibility')) {
                $table->dropColumn('visibility');
            }

            if (Schema::hasColumn('content_lessons', 'available_until')) {
                $table->dropColumn('available_until');
            }

            if (Schema::hasColumn('content_lessons', 'available_from')) {
                $table->dropColumn('available_from');
            }
        });
    }
};
