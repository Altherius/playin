<?php

use App\Enums\CardGrading;
use App\Enums\CardLanguage;
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
        Schema::create('card_print_states', static function (Blueprint $table) {
            $table->id();
            $table->string('grading')->default(CardGrading::NMINT->value);
            $table->string('language')->default(CardLanguage::ENGLISH->value);
            $table->boolean('foil')->default(false);
            $table->boolean('signed')->default(false);
            $table->boolean('altered')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('card_print_states');
    }
};
