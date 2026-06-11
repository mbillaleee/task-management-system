<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * badges table-এ badge_type এবং trigger_value যোগ করো
     * এতে XP ছাড়াও streak/task/habit count-এ badge unlock হবে
     */
    public function up(): void
    {
        Schema::table('badges', function (Blueprint $table) {
            // Badge কোন condition-এ unlock হবে
            $table->enum('badge_type', [
                'xp',               // XP পৌঁছালে
                'streak',           // streak_days পৌঁছালে
                'task_count',       // total_tasks_completed পৌঁছালে
                'habit_count',      // total_habits_completed পৌঁছালে
                'focus_sessions',   // total_focus_sessions পৌঁছালে
                'goals_completed',  // total_goals_completed পৌঁছালে
                'journals_written', // total_journals_written পৌঁছালে
                'manual',           // Admin manually দেয়
            ])->default('xp')->after('xp_required');

            // badge_type অনুযায়ী কত value লাগবে
            $table->integer('trigger_value')->default(0)->after('badge_type');
        });
    }

    public function down(): void
    {
        Schema::table('badges', function (Blueprint $table) {
            $table->dropColumn(['badge_type', 'trigger_value']);
        });
    }
};
