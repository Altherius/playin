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
        Schema::create('card_properties_lorcana', static function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('cost');
            $table->boolean('can_be_ink');
            $table->string('type_line');
            $table->text('rules_text');
            $table->integer('power')->nullable();
            $table->integer('toughness')->nullable();
            $table->integer('lore')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('card_properties_lorcana');
    }
};
