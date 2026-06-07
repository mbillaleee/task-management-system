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
        Schema::create('journals', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('journal_category_id')->nullable()->constrained()->nullOnDelete();

            $table->string('title');
            $table->longText('content')->nullable();

            $table->enum('type', ['daily', 'gratitude', 'reflection', 'personal_log'])->default('daily');
            $table->enum('mood', ['happy', 'calm', 'neutral', 'sad', 'angry', 'stressed', 'excited'])->nullable();

            $table->text('gratitude_notes')->nullable();
            $table->text('prompt')->nullable();

            $table->date('journal_date');
            $table->boolean('is_private')->default(true);
            $table->boolean('is_favorite')->default(false);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('journals');
    }
};
