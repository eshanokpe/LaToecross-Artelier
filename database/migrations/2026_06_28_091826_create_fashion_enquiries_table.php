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
        Schema::create('fashion_enquiries', function (Blueprint $table) {
            $table->id();
            
            // Foreign key to fashions table
            $table->foreignId('fashion_id')
                  ->constrained('fashions')
                  ->onDelete('cascade')
                  ->onUpdate('cascade');
            
            // Enquirer details
            $table->string('name');
            $table->string('email');
            $table->string('phone')->nullable();
            $table->text('message');
            
            // Status
            $table->boolean('is_read')->default(false);
            
            // Timestamps
            $table->timestamps();
            
            // Indexes for better performance
            $table->index('fashion_id');
            $table->index('email');
            $table->index('is_read');
            $table->index('created_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fashion_enquiries');
    }
};