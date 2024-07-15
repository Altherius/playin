<?php

namespace App\Http\Controllers;

use App\Enums\GiftCardStatus;
use App\Http\Requests\GiftCard\GiftCardCreateRequest;
use App\Http\Requests\GiftCard\GiftCardUpdateRequest;
use App\Http\Resources\GiftCardResource;
use App\Models\GiftCard;
use App\Models\StoreCreditHistory;
use App\Models\User;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\Auth;
use OpenApi\Attributes as OA;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;
use Symfony\Component\HttpKernel\Exception\UnprocessableEntityHttpException;

class GiftCardController extends Controller
{
    #[OA\Get(path: '/api/gift-cards', summary: 'Get collection of gift cards', tags: ['Gift Card'])]
    #[OA\Response(response: '200', description: 'A paginated collection of gift cards', content: new OA\JsonContent(ref: '#/components/schemas/GiftCardPaginatedCollection'))]
    public function index(): AnonymousResourceCollection
    {
        return GiftCardResource::collection(GiftCard::paginate());
    }

    #[OA\Post(path: '/api/gift-cards', summary: 'Create gift card', tags: ['Gift Card'])]
    #[OA\RequestBody(ref: '#/components/requestBodies/GiftCardCreateRequest')]
    #[OA\Response(response: '201', description: 'The created gift card', content: new OA\JsonContent(properties: [
        new OA\Property(property: 'data', ref: '#/components/schemas/GiftCard', type: 'object'),
    ]))]
    #[OA\Response(response: '400', description: 'Input format is incorrect', content: new OA\JsonContent(ref: '#/components/schemas/Error'))]
    #[OA\Response(response: '422', description: 'Input data has not been validated', content: new OA\JsonContent(ref: '#/components/schemas/Error'))]
    public function store(GiftCardCreateRequest $request): JsonResponse
    {
        $giftCard = new GiftCard();

        $giftCard->barcode = $request->barcode;
        $giftCard->value = $request->value;
        $giftCard->status = GiftCardStatus::INACTIVE;

        return (new GiftCardResource($giftCard))->response()->setStatusCode(201);
    }

    #[OA\Post(path: '/api/gift-cards/{giftCard}/activate', summary: 'Activate gift card', tags: ['Gift Card'])]
    #[OA\Parameter(name: 'giftCard', description: 'The ID of the gift card to activate', in: 'path', required: true, schema: new OA\Schema(type: 'integer'))]
    #[OA\Response(response: '200', description: 'The activated gift card', content: new OA\JsonContent(properties: [
        new OA\Property(property: 'data', ref: '#/components/schemas/GiftCard', type: 'object'),
    ]))]
    #[OA\Response(response: '422', description: 'Input data has not been validated', content: new OA\JsonContent(ref: '#/components/schemas/Error'))]
    public function activate(GiftCard $giftCard): GiftCardResource
    {

        if ($giftCard->status !== GiftCardStatus::INACTIVE) {
            throw new UnprocessableEntityHttpException('This gift card is already activated');
        }

        $giftCard->status = GiftCardStatus::ACTIVE;
        $giftCard->update();

        return new GiftCardResource($giftCard);
    }

    #[OA\Post(path: '/api/gift-cards/{giftCard}/consume', summary: 'Consume gift card', tags: ['Gift Card'])]
    #[OA\Parameter(name: 'giftCard', description: 'The ID of the gift card to consume', in: 'path', required: true, schema: new OA\Schema(type: 'integer'))]
    #[OA\Response(response: '200', description: 'The cnosumed gift card', content: new OA\JsonContent(properties: [
        new OA\Property(property: 'data', ref: '#/components/schemas/GiftCard', type: 'object'),
    ]))]
    #[OA\Response(response: '422', description: 'Input data has not been validated', content: new OA\JsonContent(ref: '#/components/schemas/Error'))]
    public function consume(GiftCard $giftCard): GiftCardResource
    {
        /** @var ?User $user */
        $user = Auth::user();

        if (! $user instanceof User) {
            throw new UnauthorizedHttpException('', 'You must be logged in to use a gift card');
        }

        if ($giftCard->status !== GiftCardStatus::ACTIVE) {
            throw new UnprocessableEntityHttpException('This gift card is not active');
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

    #[OA\Get(path: '/api/gift-cards/{id}', summary: 'Get gift card', tags: ['Gift Card'])]
    #[OA\Parameter(name: 'id', description: 'The ID of the gift card', in: 'path', required: true, schema: new OA\Schema(type: 'integer'))]
    #[OA\Response(response: '200', description: 'The required gift card', content: new OA\JsonContent(properties: [
        new OA\Property(property: 'data', ref: '#/components/schemas/GiftCard', type: 'object'),
    ]))]
    #[OA\Response(response: '404', description: 'No gift card has been found with this ID', content: new OA\JsonContent(ref: '#/components/schemas/Error'))]
    public function show(GiftCard $giftCard): GiftCardResource
    {
        return new GiftCardResource($giftCard);
    }

    #[OA\Put(path: '/api/gift-cards/{id}', summary: 'Update gift card', tags: ['Gift Card'])]
    #[OA\RequestBody(ref: '#/components/requestBodies/GiftCardUpdateRequest')]
    #[OA\Parameter(name: 'id', description: 'The ID of the gift card', in: 'path', required: true, schema: new OA\Schema(type: 'integer'))]
    #[OA\Response(response: '200', description: 'The updated gift card', content: new OA\JsonContent(properties: [
        new OA\Property(property: 'data', ref: '#/components/schemas/GiftCard', type: 'object'),
    ]))]
    #[OA\Response(response: '400', description: 'Input format is incorrect', content: new OA\JsonContent(ref: '#/components/schemas/Error'))]
    #[OA\Response(response: '422', description: 'Input data has not been validated', content: new OA\JsonContent(ref: '#/components/schemas/Error'))]
    public function update(GiftCardUpdateRequest $request, GiftCard $giftCard): GiftCardResource
    {
        $giftCard->barcode = $request->barcode;
        $giftCard->value = $request->value;

        return new GiftCardResource($giftCard);
    }
}
