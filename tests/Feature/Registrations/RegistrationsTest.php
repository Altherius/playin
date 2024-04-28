<?php

namespace Registrations;

use App\Models\Event;
use App\Models\Registration;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RegistrationsTest extends TestCase
{
    use RefreshDatabase;

    public function test_registrations_index_is_available(): void
    {
        $response = $this->get('/api/registrations');
        $response->assertOk();
    }

    public function test_registrations_page_is_available(): void
    {
        $event = Event::factory()->create();
        $user = User::factory()->create();
        $registration = Registration::factory()->withStoreAndUser($event->id, $user->id)->create();

        $response = $this->get("/api/registrations/$registration->id");
        $response->assertOk();
    }

    public function test_registrations_can_be_created(): void
    {
        $event = Event::factory()->create();
        $user = User::factory()->create();

        $response = $this->post('/api/registrations', [
            'event_id' => $event->id,
            'user_id' => $user->id,
        ]);

        $response->assertCreated();
    }

    public function test_registrations_cannot_be_created_if_event_is_full(): void
    {
        $event = Event::factory()->full()->create();
        $user = User::factory()->create();

        $response = $this->post('/api/registrations', [
            'event_id' => $event->id,
            'user_id' => $user->id,
        ]);

        $response->assertUnprocessable();
    }

    public function test_registrations_can_be_updated(): void
    {
        $event = Event::factory()->create();
        $user = User::factory()->create();
        $registration = Registration::factory()->withStoreAndUser($event->id, $user->id)->create();

        $response = $this->put("/api/registrations/$registration->id", [
            'event_id' => $event->id,
            'user_id' => $user->id,
            'paid' => true,
        ]);

        $response->assertOk();
    }

    public function test_registrations_can_be_deleted(): void
    {
        $event = Event::factory()->create();
        $user = User::factory()->create();

        $registration = Registration::factory()->withStoreAndUser($event->id, $user->id)->create();

        $response = $this->delete("/api/registrations/$registration->id");

        $response->assertNoContent();
    }
}
