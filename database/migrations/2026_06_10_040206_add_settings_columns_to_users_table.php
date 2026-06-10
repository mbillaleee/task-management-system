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
        Schema::table('users', function (Blueprint $table) {
            // Profile extras (if not already present)
            if (!Schema::hasColumn('users', 'username'))      $table->string('username')->nullable()->unique()->after('name');
            if (!Schema::hasColumn('users', 'bio'))           $table->text('bio')->nullable()->after('email');
            if (!Schema::hasColumn('users', 'phone'))         $table->string('phone', 30)->nullable();
            if (!Schema::hasColumn('users', 'gender'))        $table->string('gender', 20)->nullable();
            if (!Schema::hasColumn('users', 'date_of_birth')) $table->date('date_of_birth')->nullable();
            if (!Schema::hasColumn('users', 'country'))       $table->string('country', 100)->nullable();
            if (!Schema::hasColumn('users', 'city'))          $table->string('city', 100)->nullable();
            if (!Schema::hasColumn('users', 'timezone'))      $table->string('timezone', 60)->nullable();
            if (!Schema::hasColumn('users', 'profile'))       $table->string('profile')->nullable(); // photo filename

            // Theme & display
            if (!Schema::hasColumn('users', 'theme'))         $table->string('theme', 20)->default('dark');
            if (!Schema::hasColumn('users', 'accent_color'))  $table->string('accent_color', 20)->default('#f97316');
            if (!Schema::hasColumn('users', 'language'))      $table->string('language', 10)->default('en');
            if (!Schema::hasColumn('users', 'sidebar_compact')) $table->boolean('sidebar_compact')->default(false);

            // Notification preferences
            if (!Schema::hasColumn('users', 'notif_task_reminders'))  $table->boolean('notif_task_reminders')->default(true);
            if (!Schema::hasColumn('users', 'notif_habit_reminders')) $table->boolean('notif_habit_reminders')->default(true);
            if (!Schema::hasColumn('users', 'notif_goal_updates'))    $table->boolean('notif_goal_updates')->default(true);
            if (!Schema::hasColumn('users', 'notif_weekly_report'))   $table->boolean('notif_weekly_report')->default(true);
            if (!Schema::hasColumn('users', 'notif_xp_rewards'))      $table->boolean('notif_xp_rewards')->default(true);
            if (!Schema::hasColumn('users', 'notif_email'))           $table->boolean('notif_email')->default(false);

            // Privacy
            if (!Schema::hasColumn('users', 'profile_public'))        $table->boolean('profile_public')->default(false);
            if (!Schema::hasColumn('users', 'show_streak'))           $table->boolean('show_streak')->default(true);
            if (!Schema::hasColumn('users', 'show_xp'))               $table->boolean('show_xp')->default(true);
            if (!Schema::hasColumn('users', 'two_factor_enabled'))    $table->boolean('two_factor_enabled')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $cols = [
                'username','bio','phone','gender','date_of_birth','country','city','timezone','profile',
                'theme','accent_color','language','sidebar_compact',
                'notif_task_reminders','notif_habit_reminders','notif_goal_updates','notif_weekly_report','notif_xp_rewards','notif_email',
                'profile_public','show_streak','show_xp','two_factor_enabled',
            ];
            foreach ($cols as $col) {
                if (Schema::hasColumn('users', $col)) $table->dropColumn($col);
            }
        });
    }
};
