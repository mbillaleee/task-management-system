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
        Schema::create('notes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('note_folder_id')
                ->nullable()
                ->constrained('note_folders')
                ->nullOnDelete();

            $table->foreignId('note_category_id')
                ->nullable()
                ->constrained('note_categories')
                ->nullOnDelete();

            $table->string('title');
            $table->longText('content')->nullable();

            $table->enum('type', ['text', 'checklist'])->default('text');
            $table->enum('status', ['draft', 'published', 'archived'])->default('draft');

            $table->boolean('is_pinned')->default(false);
            $table->boolean('is_favorite')->default(false);

            $table->timestamp('last_edited_at')->nullable();

            $table->timestamps();
            $table->softDeletes();

            $table->index(['user_id', 'title']);
            $table->index(['user_id', 'is_pinned']);
            $table->index(['user_id', 'is_favorite']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notes');
    }
};
