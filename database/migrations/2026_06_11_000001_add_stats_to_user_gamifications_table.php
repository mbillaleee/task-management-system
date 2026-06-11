<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * user_gamifications table-এ নতুন stat columns যোগ করো
     * Badge trigger এবং leaderboard-এর জন্য দরকার
     */
    public function up(): void
    {
        Schema::table('user_gamifications', function (Blueprint $table) {
            // Streak tracking
            $table->integer('max_streak_days')->default(0)->after('streak_days');

            // Activity counters — badge unlock trigger করার জন্য
            $table->integer('total_tasks_completed')->default(0)->after('max_streak_days');
            $table->integer('total_habits_completed')->default(0)->after('total_tasks_completed');
            $table->integer('total_focus_sessions')->default(0)->after('total_habits_completed');
            $table->integer('total_goals_completed')->default(0)->after('total_focus_sessions');
            $table->integer('total_journals_written')->default(0)->after('total_goals_completed');
        });
    }

    public function down(): void
    {
        Schema::table('user_gamifications', function (Blueprint $table) {
            $table->dropColumn([
                'max_streak_days',
                'total_tasks_completed',
                'total_habits_completed',
                'total_focus_sessions',
                'total_goals_completed',
                'total_journals_written',
            ]);
        });
    }
};
