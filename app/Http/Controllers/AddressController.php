<?php

namespace App\Http\Controllers;

use App\Http\Resources\AddressResource;
use App\Models\Address;
use App\Models\Order;
use App\Models\Stock;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Knuckles\Scribe\Attributes\Endpoint;
use Knuckles\Scribe\Attributes\Group;

#[Group('Addresses', 'Operations related to addresses and their items')]
class AddressController extends Controller
{
    #[Endpoint('Retrieve an address')]
    public function show(Address $address): AddressResource
    {
        return new AddressResource($address);
    }

    #[Endpoint('Create an address and binds it to given user')]
    public function addCustomerAddress(Request $request, User $user): AddressResource
    {
        $request->validate([
            'address_name' => 'required',
            'recipient_name' => 'required',
            'street' => 'required',
            'postal_code' => 'required',
            'locality' => 'required',
            'country' => 'required',
        ]);

        $address = new Address();
        $address = $this->hydrateAddress($address, $request);
        $address->user_id = $user->id;
        $address->save();

        return new AddressResource($address);
    }

    #[Endpoint('Create an address and binds it to given order')]
    public function addOrderAddress(Request $request, Order $order): AddressResource
    {
        $request->validate([
            'address_name' => 'required',
            'recipient_name' => 'required',
            'street' => 'required',
            'postal_code' => 'required',
            'locality' => 'required',
            'country' => 'required',
        ]);

        $address = new Address();
        $address = $this->hydrateAddress($address, $request);
        $address->order_id = $order->id;
        $address->save();

        return new AddressResource($address);
    }

    #[Endpoint('Create an address and binds it to given stock')]
    public function addStockAddress(Request $request, Stock $stock): AddressResource
    {
        $request->validate([
            'address_name' => 'required',
            'recipient_name' => 'required',
            'street' => 'required',
            'postal_code' => 'required',
            'locality' => 'required',
            'country' => 'required',
        ]);

        $address = new Address();
        $address = $this->hydrateAddress($address, $request);
        $address->stock_id = $stock->id;
        $address->save();

        return new AddressResource($address);
    }

    #[Endpoint('Update an address')]
    public function update(Request $request, Address $address): AddressResource
    {
        $request->validate([
            'address_name' => 'required',
            'recipient_name' => 'required',
            'street' => 'required',
            'postal_code' => 'required',
            'locality' => 'required',
            'country' => 'required',
        ]);

        $address = $this->hydrateAddress($address, $request);
        $address->save();

        return new AddressResource($address);
    }

    #[Endpoint('Delete an address')]
    public function destroy(Address $address): Response
    {
        $address->delete();

        return response()->noContent();
    }

    private function hydrateAddress(Address $address, Request $request): Address
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
