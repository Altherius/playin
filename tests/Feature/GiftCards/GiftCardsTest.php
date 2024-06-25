<?php

namespace Events;

use App\Models\Event;
use App\Models\Store;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class EventsTest extends TestCase
{
    use RefreshDatabase;

    public function test_events_index_is_available(): void
    {
        $response = $this->get('/api/events');
        $response->assertOk();
    }

    public function test_events_page_is_available(): void
    {
        $event = Event::factory()->create();

        $response = $this->get("/api/events/$event->id");
        $response->assertOk();
    }

    public function test_events_can_be_created(): void
    {
        $store = Store::factory()->create();

        $response = $this->post('/api/events', [
            'name' => 'Test Event',
            'store_id' => $store->id,
            'start_time' => '2024-04-27',
            'end_time' => '2024-04-28',
            'max_capacity' => 32,
            'price' => 29.9,
        ]);

        $response->assertCreated();
    }

    public function test_events_can_be_updated(): void
    {
        $event = Event::factory()->create();
        $store = Store::factory()->create();

        $response = $this->put("/api/events/$event->id", [
            'name' => 'Test Event',
            'store_id' => $store->id,
            'start_time' => '2024-04-27',
            'end_time' => '2024-04-28',
            'max_capacity' => 32,
            'price' => 39.9,
        ]);

        $response->assertOk();
    }
}
