<?php

namespace Addresses;

use App\Models\Address;
use App\Models\Order;
use App\Models\Stock;
use App\Models\User;
use Tests\TestCase;

class AddressesTest extends TestCase
{
    public function test_addresses_page_is_available(): void
    {
        $address = Address::factory()->create();

        $response = $this->get("/api/addresses/$address->id");
        $response->assertOk();
    }

    public function test_addresses_can_be_created_with_users(): void
    {
        $user = User::factory()->create();

        $response = $this->post("/api/users/$user->id/addresses", [
            'address_name' => 'Test',
            'recipient_name' => 'John Doe',
            'street' => '1 Test Street',
            'postal_code' => '00000',
            'locality' => 'Test City',
            'country' => 'France',
        ]);

        $response->assertCreated();
    }

    public function test_addresses_can_be_created_with_orders(): void
    {
        $order = Order::factory()->create();

        $response = $this->post("/api/orders/$order->id/addresses", [
            'address_name' => 'Test',
            'recipient_name' => 'John Doe',
            'street' => '1 Test Street',
            'postal_code' => '00000',
            'locality' => 'Test City',
            'country' => 'France',
        ]);

        $response->assertCreated();
    }

    public function test_addresses_can_be_created_with_stocks(): void
    {
        $stock = Stock::factory()->create();

        $response = $this->post("/api/stocks/$stock->id/addresses", [
            'address_name' => 'Test',
            'recipient_name' => 'John Doe',
            'street' => '1 Test Street',
            'postal_code' => '00000',
            'locality' => 'Test City',
            'country' => 'France',
        ]);

        $response->assertCreated();
    }

    public function test_addresses_can_be_updated(): void
    {
        $address = Address::factory()->create();

        $response = $this->put("/api/addresses/$address->id", [
            'address_name' => 'Test',
            'recipient_name' => 'John Doe',
            'street' => '1 Test Street',
            'postal_code' => '00000',
            'locality' => 'Test City',
            'country' => 'France',
        ]);

        $response->assertOk();
    }

    public function test_addresses_can_be_deleted(): void
    {
        $address = Address::factory()->create();

        $response = $this->delete("/api/addresses/$address->id");

        $response->assertNoContent();
    }
}
