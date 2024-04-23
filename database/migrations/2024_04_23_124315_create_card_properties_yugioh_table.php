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
        Schema::create('card_properties_yugioh', static function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('level');
            $table->string('type_line');
            $table->text('rules_text');
            $table->integer('atk')->nullable();
            $table->integer('def')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('card_properties_yugioh');
    }
};
