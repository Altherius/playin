<?php

namespace App\Http\Controllers;

use App\Http\Requests\Address\AddressCreateRequest;
use App\Http\Resources\AddressResource;
use App\Models\Address;
use App\Models\Order;
use App\Models\Stock;
use App\Models\User;
use Illuminate\Http\Response;

class AddressController extends Controller
{
    public function show(Address $address): AddressResource
    {
        return new AddressResource($address);
    }

    public function addCustomerAddress(AddressCreateRequest $request, User $user): AddressResource
    {
        $address = new Address();
        $address = $this->hydrateAddress($address, $request);
        $address->user_id = $user->id;
        $address->save();

        return new AddressResource($address);
    }

    public function addOrderAddress(AddressCreateRequest $request, Order $order): AddressResource
    {
        $address = new Address();
        $address = $this->hydrateAddress($address, $request);
        $address->order_id = $order->id;
        $address->save();

        return new AddressResource($address);
    }

    public function addStockAddress(AddressCreateRequest $request, Stock $stock): AddressResource
    {
        $address = new Address();
        $address = $this->hydrateAddress($address, $request);
        $address->stock_id = $stock->id;
        $address->save();

        return new AddressResource($address);
    }

    public function update(AddressCreateRequest $request, Address $address): AddressResource
    {
        $address = $this->hydrateAddress($address, $request);
        $address->save();

        return new AddressResource($address);
    }

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
