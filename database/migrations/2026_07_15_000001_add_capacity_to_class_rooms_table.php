<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('class_rooms', function (Blueprint $table) {
            if (! Schema::hasColumn('class_rooms', 'capacity')) {
                $table->unsignedInteger('capacity')->nullable()->after('room');
            }
        });
    }

    public function down(): void
    {
        Schema::table('class_rooms', function (Blueprint $table) {
            if (Schema::hasColumn('class_rooms', 'capacity')) {
                $table->dropColumn('capacity');
            }
        });
    }
};
