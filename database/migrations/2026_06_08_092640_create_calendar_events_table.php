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
        Schema::create('calendar_events', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
 
            $table->string('title');
            $table->text('description')->nullable();
            $table->string('location')->nullable();
 
            $table->date('start_date');
            $table->time('start_time')->nullable();
            $table->date('end_date');
            $table->time('end_time')->nullable();
 
            $table->boolean('all_day')->default(false);
 
            $table->enum('type', ['event', 'reminder', 'block', 'meeting', 'personal', 'task'])->default('event');
            $table->enum('priority', ['low', 'medium', 'high'])->default('medium');
 
            $table->string('color', 20)->default('orange'); // orange, blue, green, pink, purple, red, yellow
 
            $table->boolean('is_recurring')->default(false);
            $table->enum('recurring_type', ['daily', 'weekly', 'monthly', 'yearly'])->nullable();
            $table->date('recurring_end_date')->nullable();
 
            $table->boolean('reminder_enabled')->default(false);
            $table->integer('reminder_minutes')->default(15); // minutes before event
 
            $table->enum('status', ['upcoming', 'completed', 'cancelled'])->default('upcoming');
 
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('calendar_events');
    }
};
