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
        Schema::table('tasks', function (Blueprint $table) {
            $table->boolean('reminder_enabled')->default(false)->after('due_date');
            $table->timestamp('remind_at')->nullable()->after('reminder_enabled');
            $table->timestamp('reminder_sent_at')->nullable()->after('remind_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tasks', function (Blueprint $table) {
            $table->dropColumn([
                'reminder_enabled',
                'remind_at',
                'reminder_sent_at',
            ]);
        });
    }
};
