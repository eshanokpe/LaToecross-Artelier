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
        Schema::create('artworks', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('artist');
            $table->text('description')->nullable();
            $table->string('medium')->nullable();       // e.g. Oil on canvas, Acrylic, Photography
            $table->string('style')->nullable(); // realism, impressionism, abstract, mixed_media
            $table->string('dimensions')->nullable();   // e.g. 60cm × 80cm
            $table->decimal('price', 12, 2)->nullable();// Supports values up to ₦99,999,999.99
            $table->boolean('is_for_sale')->default(false);
            $table->boolean('is_featured')->default(false);
            $table->string('image');                     // Stores relative path e.g. "artworks/filename.jpg"
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('artworks');
    }
};