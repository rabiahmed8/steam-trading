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
        Schema::create('steam_market_items', function (Blueprint $table) {
            $table->id();
            $table->string('game');
            $table->string('icon');
            $table->string('icon_large');
            $table->string('name');
            $table->text('data');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('steam_market_items');
    }
};
