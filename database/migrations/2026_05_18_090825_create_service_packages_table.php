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
        Schema::create('service_packages', function (Blueprint $table) {
            $table->id();
            $table->foreignId('service_id')->constrained('services')->cascadeOnDelete();

            $table->enum('type', ['basic', 'standard', 'premium']);
            $table->string('title');
            $table->decimal('price', 10, 2);
            $table->text('description')->nullable();

            $table->integer('delivery_days')->default(9);
            $table->integer('revisions')->default(0);

            $table->longText('included')->nullable(); 
            // JSON/text: ["Website Redesign", "Responsive Design", "SEO Optimization"]

            $table->boolean('status')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('service_packages');
    }
};
