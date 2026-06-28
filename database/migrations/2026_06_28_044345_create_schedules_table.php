<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('schedules', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('teacher_id');
            $table->unsignedBigInteger('class_id');

            $table->string('day');
            $table->time('start_time');
            $table->time('end_time');

            $table->timestamps();

            // Foreign keys referencing correct tables and primary keys
            $table->foreign('teacher_id')
                ->references('teacher_id')
                ->on('teachers')
                ->cascadeOnDelete();

            $table->foreign('class_id')
                ->references('class_room_id')
                ->on('class_rooms')
                ->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('schedules');
    }
};
