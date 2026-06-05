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
        Schema::create('goals', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('goal_category_id')->nullable()->constrained()->nullOnDelete();

            $table->string('title');
            $table->text('description')->nullable();

            $table->enum('type', ['short_term', 'long_term'])->default('long_term');
            $table->enum('status', ['not_started', 'in_progress', 'completed', 'cancelled'])->default('not_started');
            $table->enum('priority', ['low', 'medium', 'high'])->default('medium');

            $table->date('start_date')->nullable();
            $table->date('deadline')->nullable();

            $table->integer('progress')->default(0);
            $table->integer('xp_earned')->default(0);
            $table->timestamp('completed_at')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('goals');
    }
};
