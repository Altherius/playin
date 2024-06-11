<?php

namespace Tests\Feature\StoreCredit;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class StoreCreditTest extends TestCase
{
    use RefreshDatabase;

    public function test_store_credit_history_index_is_available(): void
    {
        $response = $this->get('/api/store-credit-histories');

        $response->assertStatus(200);
    }

    public function test_store_credit_history_for_user_is_available(): void
    {
        $user = User::factory()->create();

        $response = $this->get("/api/users/$user->id/store-credit-history");

        $response->assertStatus(200);
    }
}
