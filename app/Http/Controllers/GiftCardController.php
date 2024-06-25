<?php

namespace App\Http\Controllers;

use App\Enums\GiftCardStatus;
use App\Http\Resources\GiftCardResource;
use App\Models\GiftCard;
use App\Models\StoreCreditHistory;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;
use Symfony\Component\HttpKernel\Exception\UnprocessableEntityHttpException;

class GiftCardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): AnonymousResourceCollection
    {
        return GiftCardResource::collection(GiftCard::paginate());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    public function activate(GiftCard $giftCard): GiftCardResource
    {

        if ($giftCard->status !== GiftCardStatus::INACTIVE) {
            throw new UnprocessableEntityHttpException("This gift card is already activated");
        }

        $giftCard->status = GiftCardStatus::ACTIVE;
        $giftCard->update();

        return new GiftCardResource($giftCard);
    }

    public function consume(GiftCard $giftCard): GiftCardResource
    {
        /** @var ?User $user */
        $user = Auth::user();

        if (!$user instanceof User) {
            throw new UnauthorizedHttpException("", "You must be logged in to use a gift card");
        }

        if ($giftCard->status !== GiftCardStatus::ACTIVE) {
            throw new UnprocessableEntityHttpException("This gift card is not active");
        }

        $giftCard->status = GiftCardStatus::USED;
        $giftCard->update();

        $storeCreditHistory = new StoreCreditHistory();
        $storeCreditHistory->comment = "Gift card #$giftCard->barcode";
        $storeCreditHistory->credit = $giftCard->value;
        $storeCreditHistory->customer_id = $user->id;
        $storeCreditHistory->save();

        return new GiftCardResource($giftCard);
    }

    /**
     * Display the specified resource.
     */
    public function show(GiftCard $giftCard): GiftCardResource
    {
        return new GiftCardResource($giftCard);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, GiftCard $giftCard)
    {
        //
    }
}
