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
        Schema::create('focus_sessions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();

            $table->string('title')->nullable();

            $table->enum('type', [
                'pomodoro',
                'deep_work',
                'focus_timer',
                'break'
            ])->default('pomodoro');

            $table->integer('duration_minutes')->default(25);
            $table->integer('completed_minutes')->default(0);

            $table->enum('status', [
                'pending',
                'running',
                'paused',
                'completed',
                'cancelled'
            ])->default('pending');

            $table->enum('ambient_sound', [
                'none',
                'white_noise',
                'rain',
                'lofi'
            ])->default('none');

            $table->boolean('fullscreen_mode')->default(false);
            $table->boolean('distraction_free')->default(false);

            $table->timestamp('started_at')->nullable();
            $table->timestamp('paused_at')->nullable();
            $table->timestamp('completed_at')->nullable();

            $table->integer('xp_earned')->default(0);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('focus_sessions');
    }
};
