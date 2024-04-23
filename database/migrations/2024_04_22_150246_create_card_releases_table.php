<?php

use App\Models\CardEdition;
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
        Schema::create('card_releases', static function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(CardEdition::class)->nullable();
            $table->string('collection_number');
            $table->string('artist');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('card_releases');
    }
};
