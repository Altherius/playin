<?php

use App\Models\Address;
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
        Schema::table('orders', function (Blueprint $table) {
            $table->foreignIdFor(Address::class)->nullable()->constrained();
        });

        Schema::table('stocks', function (Blueprint $table) {
            $table->foreignIdFor(Address::class)->nullable()->constrained();
        });

        Schema::table('users', function (Blueprint $table) {
            $table->foreignIdFor(Address::class)->nullable()->constrained();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropForeignIdFor(Address::class);
        });

        Schema::table('stocks', function (Blueprint $table) {
            $table->dropForeignIdFor(Address::class);
        });

        Schema::table('users', function (Blueprint $table) {
            $table->dropForeignIdFor(Address::class);
        });
    }
};
