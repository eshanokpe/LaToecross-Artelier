<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('fashions', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description')->nullable();
            $table->string('fabric')->nullable();
            $table->string('category')->nullable(); // e.g. Wearable Art, Accessories
            $table->string('dimensions')->nullable();
            $table->decimal('price', 12, 2)->nullable();
            $table->boolean('is_for_sale')->default(false);
            $table->boolean('is_featured')->default(false);
            $table->string('image');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('fashion');
    }
};