<?php

namespace GiftCards;

use App\Enums\GiftCardStatus;
use App\Models\GiftCard;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;

class GiftCardsTest extends TestCase
{
    use RefreshDatabase;

    public function test_gift_cards_index_is_available(): void
    {
        $response = $this->get('/api/gift-cards');
        $response->assertOk();
    }

    public function test_gift_cards_page_is_available(): void
    {
        $giftCard = GiftCard::factory()->create();

        $response = $this->get("/api/gift-cards/$giftCard->id");
        $response->assertOk();
    }

    public function test_gift_cards_can_be_created(): void
    {
        $response = $this->post('/api/gift-cards', [
            'barcode' => '0000000000000',
            'value' => 50,
        ]);

        $response->assertCreated();

        $response->assertJson(fn (AssertableJson $json) => $json->where('data.barcode', '0000000000000')
            ->where('data.value', 50)
        );
    }

    public function test_gift_cards_can_be_updated(): void
    {
        $giftCard = GiftCard::factory()->create();

        $response = $this->put("/api/gift-cards/$giftCard->id", [
            'barcode' => '0000000000000',
            'value' => 50,
        ]);

        $response->assertOk();

        $response->assertJson(fn (AssertableJson $json) => $json->where('data.barcode', '0000000000000')
            ->where('data.value', 50)
        );
    }

    public function test_gift_cards_can_be_activated(): void
    {
        $giftCard = GiftCard::factory()->inactive()->create();

        $response = $this->post("/api/gift-cards/$giftCard->id/activate");

        $response->assertOk();

        $response->assertJson(fn (AssertableJson $json) => $json->where('data.status', GiftCardStatus::ACTIVE->value)
        );
    }

    public function test_gift_cards_can_be_consumed(): void
    {
        $giftCard = GiftCard::factory()->active()->create();
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post("/api/gift-cards/$giftCard->id/consume");

        $response->assertOk();

        $response->assertJson(fn (AssertableJson $json) => $json->where('data.status', GiftCardStatus::USED->value)
        );

        $user = $user->refresh();
        $this->assertEquals($giftCard->value, $user->store_credit);
    }
}
