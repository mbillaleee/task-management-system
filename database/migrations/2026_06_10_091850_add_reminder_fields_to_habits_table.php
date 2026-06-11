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
        Schema::table('habits', function (Blueprint $table) {
            if (!Schema::hasColumn('habits', 'reminder_enabled')) {
                $table->boolean('reminder_enabled')->default(false)->after('start_date');
            }
            if (!Schema::hasColumn('habits', 'remind_time')) {
                // e.g. "08:30" — daily time for the reminder
                $table->time('remind_time')->nullable()->after('reminder_enabled');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('habits', function (Blueprint $table) {
            //
        });
    }
};
