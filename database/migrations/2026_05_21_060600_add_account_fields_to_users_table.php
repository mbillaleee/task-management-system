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
            $table->string('phone')->nullable()->after('email');
            $table->string('username')->nullable()->unique()->after('phone');
            $table->string('profile')->nullable()->after('username');
            $table->text('bio')->nullable()->after('profile');
            $table->string('gender')->nullable()->after('bio');
            $table->date('date_of_birth')->nullable()->after('gender');
            $table->string('country')->nullable()->after('date_of_birth');
            $table->string('city')->nullable()->after('country');
            $table->string('timezone')->nullable()->after('city');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropUnique(['username']);
            $table->dropColumn([
                'phone',
                'username',
                'profile',
                'bio',
                'gender',
                'date_of_birth',
                'country',
                'city',
                'timezone',
            ]);
        });
    }
};
