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
        Schema::create('boardgame_properties', static function (Blueprint $table) {
            $table->id();
            $table->integer('min_player_count');
            $table->integer('max_player_count');
            $table->integer('min_player_age');
            $table->integer('max_player_age')->nullable();
            $table->integer('game_length_minutes');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('boardgame_properties');
    }
};
