<?php

use App\Enums\PaymentMode;
use App\Enums\PaymentStatus;
use App\Models\Store;
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
        Schema::create('orders', static function (Blueprint $table) {
            $table->id();
            $table
                ->foreignIdFor(User::class, 'customer_id')
                ->constrained()->references('id')->on('users');
            $table->foreignIdFor(Store::class, 'store_id')
                ->constrained()->references('id')->on('stores');
            $table->boolean('validated')->default(false);
            $table->boolean('sent')->default(false);
            $table->boolean('received')->default(false);
            $table->string('payment_status')->default(PaymentStatus::AWAITING_PAYMENT);
            $table->string('payment_mode')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
