<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('discussion_reactions', function (Blueprint $table) {
            $table->bigIncrements('discussion_reaction_id');
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->unsignedBigInteger('discussion_post_id')->nullable();
            $table->unsignedBigInteger('discussion_comment_id')->nullable();
            $table->string('type', 24)->default('like');
            $table->timestamps();

            $table->foreign('discussion_post_id')
                ->references('discussion_post_id')
                ->on('discussion_posts')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();

            $table->foreign('discussion_comment_id')
                ->references('discussion_comment_id')
                ->on('discussion_comments')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();

            $table->unique(['user_id', 'discussion_post_id']);
            $table->unique(['user_id', 'discussion_comment_id']);
            $table->index(['discussion_post_id', 'type']);
            $table->index(['discussion_comment_id', 'type']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('discussion_reactions');
    }
};
