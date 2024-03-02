<?php

use App\Models\Product;
use App\Models\Stock;
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
        Schema::create('stock_items', static function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Stock::class, 'stock_id')->constrained();
            $table->foreignIdFor(Product::class, 'product_id')->constrained();
            $table->integer('quantity')->default(1);
            $table->float('unit_price');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stock_items');
    }
};
