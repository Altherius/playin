<?php

use App\Models\Product;
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
        Schema::create('card_properties_magic', static function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('mana_cost');
            $table->string('type_line');
            $table->text('rules_text');
            $table->integer('mana_value');
            $table->float('power')->nullable();
            $table->float('toughness')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('card_properties_magic');
    }
};
