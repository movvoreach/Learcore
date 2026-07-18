<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('departments', function (Blueprint $table) {
            $table->bigIncrements('department_id');
            $table->unsignedBigInteger('faculty_id')->nullable();
            $table->string('department_code', 30)->unique();
            $table->string('department_name', 150);
            $table->string('deans', 255)->nullable();
            $table->timestamps();

            $table->foreign('faculty_id')
                ->references('faculty_id')
                ->on('faculties')
                ->cascadeOnUpdate()
                ->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('departments');
    }
};
