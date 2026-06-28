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
        Schema::create('activity_logs', function (Blueprint $table) {
            $table->id();
            $table->string('action'); // created, updated, deleted
            $table->string('model_type'); // e.g. App\Models\User
            $table->unsignedBigInteger('model_id');
            $table->unsignedBigInteger('user_id')->nullable(); // Who performed the action
            $table->json('old_values')->nullable(); // State before
            $table->json('new_values')->nullable(); // State after
            $table->string('ip_address')->nullable();
            $table->timestamps();

            $table->index(['model_type', 'model_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('activity_logs');
    }
};
