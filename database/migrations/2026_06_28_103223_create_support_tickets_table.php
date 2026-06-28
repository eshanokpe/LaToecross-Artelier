<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('support_tickets', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email');
            $table->string('phone')->nullable();
            $table->string('subject');
            $table->text('message');
            $table->string('status')->default('pending');
            $table->boolean('is_read')->default(false);
            $table->timestamps();
            
            $table->index('email');
            $table->index('status');
            $table->index('is_read');
        });
    }

    public function down()
    {
        Schema::dropIfExists('support_tickets');
    }
};