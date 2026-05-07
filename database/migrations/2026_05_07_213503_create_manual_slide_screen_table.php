<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('manual_slide_screen', function (Blueprint $table) {
            $table->id();

            $table->foreignId('manual_slide_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->foreignId('screen_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->timestamps();

            $table->unique(['manual_slide_id', 'screen_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('manual_slide_screen');
    }
};