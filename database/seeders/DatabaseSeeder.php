<?php

namespace Database\Seeders;

use App\Models\Address;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $users = \App\Models\User::factory(10)->has(Address::factory()->count(2))->create();
        $stores = \App\Models\Store::factory(3)->create();
        \App\Models\Product::factory(10)->create();
        \App\Models\Product::factory(10)->boardgame()->create();
        \App\Models\Product::factory(10)->magic()->create();
        \App\Models\Product::factory(10)->yugioh()->create();
        \App\Models\Product::factory(10)->fab()->create();
        \App\Models\Product::factory(10)->lorcana()->create();
        \App\Models\Order::factory(5)->has(Address::factory())->recycle($users)->recycle($stores)->create();
        \App\Models\Stock::factory(5)->has(Address::factory())->recycle($users)->recycle($stores)->create();
        \App\Models\BoardgameProperties::factory(5)->create();
        \App\Models\CardPropertiesMagic::factory(1)->create();
        \App\Models\CardPropertiesYugioh::factory(1)->create();
        \App\Models\CardPropertiesFab::factory(1)->create();
        \App\Models\CardPropertiesLorcana::factory(1)->create();
        \App\Models\CardPrintState::factory(1)->create();
        \App\Models\CardEdition::factory(10)->create();
        \App\Models\CardRelease::factory(1)->create();
        \App\Models\Event::factory(10)->recycle($stores)->create();
    }
}
