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
        Schema::create('subscription_plans', function (Blueprint $table) {
              $table->id();
            $table->string('name');                          // Free, Pro, Enterprise
            $table->string('slug')->unique();                // free, pro, enterprise
            $table->text('description')->nullable();
            $table->string('badge_label')->nullable();       // "Most Popular", "Best Value"
            $table->string('badge_color')->default('#f97316'); // badge bg hex
            $table->decimal('price_monthly', 10, 2)->default(0);
            $table->decimal('price_yearly', 10, 2)->default(0);
            $table->string('currency')->default('USD');
            $table->string('icon')->nullable();              // emoji or icon class
            $table->string('color')->default('#f97316');     // plan accent hex color
            // Feature limits (-1 = unlimited)
            $table->integer('max_tasks')->default(-1);
            $table->integer('max_habits')->default(-1);
            $table->integer('max_notes')->default(-1);
            $table->integer('max_goals')->default(-1);
            $table->integer('max_focus_sessions')->default(-1);
            $table->integer('max_journals')->default(-1);
            // Feature flags
            $table->boolean('has_analytics')->default(false);
            $table->boolean('has_calendar')->default(false);
            $table->boolean('has_gamification')->default(false);
            $table->boolean('has_themes')->default(false);
            $table->boolean('has_ai_tools')->default(false);
            $table->boolean('has_team_workspace')->default(false);
            $table->boolean('has_priority_support')->default(false);
            // JSON for any extra custom features list
            $table->json('features')->nullable();
            $table->integer('sort_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->boolean('is_featured')->default(false);  // highlighted on pricing page
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('subscription_plans');
    }
};
