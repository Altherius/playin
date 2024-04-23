<?php

use App\Enums\ProductType;
use App\Models\CardPrintState;
use App\Models\CardPropertiesMagic;
use App\Models\CardRelease;
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
        Schema::create('products', static function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('card_game')->nullable()->default(null);
            $table->string('product_type')->default(ProductType::OTHER->value);
            $table->foreignIdFor(CardPropertiesMagic::class, 'card_properties_magic_id')->nullable();
            $table->foreignIdFor(CardPrintState::class)->nullable();
            $table->foreignIdFor(CardRelease::class)->nullable();
            $table->float('price');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
