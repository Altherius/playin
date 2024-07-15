<?php

namespace App\Http\Controllers;

use App\Http\Requests\Address\AddressCreateRequest;
use App\Http\Resources\AddressResource;
use App\Models\Address;
use App\Models\Order;
use App\Models\Stock;
use App\Models\User;
use Illuminate\Http\Response;
use OpenApi\Attributes as OA;

class AddressController extends Controller
{
    #[OA\Get(path: '/api/addresses/{id}', summary: 'Get address', tags: ['Address'])]
    #[OA\Parameter(name: 'id', description: 'The ID of the address', in: 'path', required: true, schema: new OA\Schema(type: 'integer'))]
    #[OA\Response(response: '200', description: 'The requested address', content: new OA\JsonContent(properties: [
        new OA\Property(property: 'data', ref: '#/components/schemas/Address', type: 'object'),
    ]))]
    public function show(Address $address): AddressResource
    {
        return new AddressResource($address);
    }

    #[OA\Post(path: '/api/users/{user}/addresses', summary: 'Create address bound to user', tags: ['Address'])]
    #[OA\RequestBody(ref: '#/components/requestBodies/AddressCreateRequest')]
    #[OA\Parameter(name: 'user', description: 'The ID of the user', in: 'path', required: true, schema: new OA\Schema(type: 'integer'))]
    #[OA\Response(response: '201', description: 'The created address', content: new OA\JsonContent(properties: [
        new OA\Property(property: 'data', ref: '#/components/schemas/Address', type: 'object'),
    ]))]
    #[OA\Response(response: '400', description: 'Input format is incorrect', content: new OA\JsonContent(ref: '#/components/schemas/Error'))]
    #[OA\Response(response: '422', description: 'Input data has not been validated', content: new OA\JsonContent(ref: '#/components/schemas/Error'))]
    public function addCustomerAddress(AddressCreateRequest $request, User $user): AddressResource
    {
        $address = new Address();
        $address = $this->hydrateAddress($address, $request);
        $address->user_id = $user->id;
        $address->save();

        return new AddressResource($address);
    }

    #[OA\Post(path: '/api/orders/{order}/addresses', summary: 'Create address bound to order', tags: ['Address'])]
    #[OA\RequestBody(ref: '#/components/requestBodies/AddressCreateRequest')]
    #[OA\Parameter(name: 'order', description: 'The ID of the order', in: 'path', required: true, schema: new OA\Schema(type: 'integer'))]
    #[OA\Response(response: '201', description: 'The created address', content: new OA\JsonContent(properties: [
        new OA\Property(property: 'data', ref: '#/components/schemas/Address', type: 'object'),
    ]))]
    #[OA\Response(response: '400', description: 'Input format is incorrect', content: new OA\JsonContent(ref: '#/components/schemas/Error'))]
    #[OA\Response(response: '422', description: 'Input data has not been validated', content: new OA\JsonContent(ref: '#/components/schemas/Error'))]
    public function addOrderAddress(AddressCreateRequest $request, Order $order): AddressResource
    {
        $address = new Address();
        $address = $this->hydrateAddress($address, $request);
        $address->order_id = $order->id;
        $address->save();

        return new AddressResource($address);
    }

    #[OA\Post(path: '/api/stocks/{stock}/addresses', summary: 'Create address bound to stock', tags: ['Address'])]
    #[OA\RequestBody(ref: '#/components/requestBodies/AddressCreateRequest')]
    #[OA\Parameter(name: 'stock', description: 'The ID of the stock', in: 'path', required: true, schema: new OA\Schema(type: 'integer'))]
    #[OA\Response(response: '201', description: 'The created address', content: new OA\JsonContent(properties: [
        new OA\Property(property: 'data', ref: '#/components/schemas/Address', type: 'object'),
    ]))]
    #[OA\Response(response: '400', description: 'Input format is incorrect', content: new OA\JsonContent(ref: '#/components/schemas/Error'))]
    #[OA\Response(response: '422', description: 'Input data has not been validated', content: new OA\JsonContent(ref: '#/components/schemas/Error'))]
    public function addStockAddress(AddressCreateRequest $request, Stock $stock): AddressResource
    {
        $address = new Address();
        $address = $this->hydrateAddress($address, $request);
        $address->stock_id = $stock->id;
        $address->save();

        return new AddressResource($address);
    }

    #[OA\Put(path: '/api/addresses/{id}', summary: 'Update address', tags: ['Address'])]
    #[OA\RequestBody(ref: '#/components/requestBodies/AddressCreateRequest')]
    #[OA\Parameter(name: 'id', description: 'The ID of the address', in: 'path', required: true, schema: new OA\Schema(type: 'integer'))]
    #[OA\Response(response: '200', description: 'The created address', content: new OA\JsonContent(properties: [
        new OA\Property(property: 'data', ref: '#/components/schemas/Address', type: 'object'),
    ]))]
    #[OA\Response(response: '400', description: 'Input format is incorrect', content: new OA\JsonContent(ref: '#/components/schemas/Error'))]
    #[OA\Response(response: '422', description: 'Input data has not been validated', content: new OA\JsonContent(ref: '#/components/schemas/Error'))]
    public function update(AddressCreateRequest $request, Address $address): AddressResource
    {
        $address = $this->hydrateAddress($address, $request);
        $address->save();

        return new AddressResource($address);
    }

    #[OA\Delete(path: '/api/addresses/{id}', summary: 'Delete address', tags: ['Address'])]
    #[OA\Parameter(name: 'id', description: 'The ID of the address', in: 'path', required: true, schema: new OA\Schema(type: 'integer'))]
    #[OA\Response(response: '204', description: 'Address has been deleted successfully')]
    public function destroy(Address $address): Response
    {
        $address->delete();

        return response()->noContent();
    }

    private function hydrateAddress(Address $address, AddressCreateRequest $request): Address
    {
        $address->address_name = $request->address_name;
        $address->recipient_name = $request->recipient_name;
        $address->street = $request->street;
        $address->postal_code = $request->postal_code;
        $address->locality = $request->locality;
        $address->country = $request->country;

        return $address;
    }
}
