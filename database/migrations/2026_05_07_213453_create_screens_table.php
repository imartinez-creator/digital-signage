<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('screens', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->boolean('is_blocked')->default(false);
            $table->string('blocked_message')->nullable();
            $table->enum('content_order', ['manual_first', 'web_first'])->default('manual_first');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('screens');
    }
};