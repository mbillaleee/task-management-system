<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * user_challenges-এ joined_at column যোগ করো
     * challenge কখন join করেছে সেটা track করার জন্য
     */
    public function up(): void
    {
        Schema::table('user_challenges', function (Blueprint $table) {
            $table->timestamp('joined_at')->nullable()->after('challenge_id');
        });
    }

    public function down(): void
    {
        Schema::table('user_challenges', function (Blueprint $table) {
            $table->dropColumn('joined_at');
        });
    }
};
