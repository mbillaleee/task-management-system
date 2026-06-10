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
            $table->time('due_time')->nullable()->after('due_date');
            $table->boolean('is_recurring')->default(false)->after('due_time');
            $table->enum('recurring_type', ['daily', 'weekly', 'monthly'])->nullable()->after('is_recurring');
            $table->date('recurring_end_date')->nullable()->after('recurring_type');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tasks', function (Blueprint $table) {
            $table->dropColumn(['due_time', 'is_recurring', 'recurring_type', 'recurring_end_date']);
        });
    }
};
