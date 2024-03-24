<?php

use App\Models\Order;
use App\Models\Stock;
use App\Models\User;
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
        Schema::create('addresses', function (Blueprint $table) {
            $table->id();
            $table->string('address_name');
            $table->string('recipient_name');
            $table->string('street');
            $table->string('postal_code');
            $table->string('locality');
            $table->string('region')->nullable();
            $table->string('country');
            $table->string('additional_information')->nullable();
            $table->foreignIdFor(User::class)->nullable()->constrained();
            $table->foreignIdFor(Order::class)->nullable()->constrained();
            $table->foreignIdFor(Stock::class)->nullable()->constrained();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('addresses');
    }
};
