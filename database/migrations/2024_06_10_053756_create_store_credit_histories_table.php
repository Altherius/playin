<?php

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
        Schema::create('store_credit_histories', function (Blueprint $table) {
            $table->id();
            $table->string('comment');
            $table->float('credit');
            $table->foreignIdFor(User::class, 'customer_id');
            $table->foreignIdFor(User::class, 'collaborator_id')->nullable();
            $table->timestamps();
        });

        Schema::table('users', function (Blueprint $table) {
            $table->float('store_credit')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('store_credit_histories');

        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('store_credit');
        });
    }
};
