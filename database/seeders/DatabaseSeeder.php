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
        \App\Models\User::factory(10)->has(Address::factory()->count(2))->create();
        \App\Models\Product::factory(100)->create();
        \App\Models\Store::factory(3)->create();
        \App\Models\Order::factory(5)->has(Address::factory())->create();
        \App\Models\Stock::factory(5)->has(Address::factory())->create();
    }
}
