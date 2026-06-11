<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * challenges table-এ challenge_action যোগ করো।
     *
     * challenge_action বলে দেয় কোন real activity-তে
     * এই challenge-এর progress auto বাড়বে।
     *
     * manual  → user নিজে input দিয়ে add করে (আগের মতো)
     * complete_task    → task complete হলে +1
     * log_habit        → habit log করলে +1
     * finish_focus     → focus session complete হলে +1
     * complete_goal    → goal complete হলে +1
     * write_journal    → journal entry লিখলে +1
     * login_streak     → daily login claim করলে +1
     */
    public function up(): void
    {
        Schema::table('challenges', function (Blueprint $table) {
            $table->enum('challenge_action', [
                'manual',
                'complete_task',
                'log_habit',
                'finish_focus',
                'complete_goal',
                'write_journal',
                'login_streak',
            ])->default('manual')->after('type');
        });
    }

    public function down(): void
    {
        Schema::table('challenges', function (Blueprint $table) {
            $table->dropColumn('challenge_action');
        });
    }
};
