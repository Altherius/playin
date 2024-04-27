<?php

namespace App\Http\Controllers;

use App\Http\Resources\RegistrationResource;
use App\Models\Registration;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;

class RegistrationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): AnonymousResourceCollection
    {
        return RegistrationResource::collection(Registration::paginate());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RegistrationResource
    {
        $request->validate([
            'event_id' => 'required|exists:events,id',
            'user_id' => 'required|exists:users,id',
        ]);

        $registration = new Registration();
        $registration->user_id = $request->user_id;
        $registration->event_id = $request->event_id;

        $registration->save();

        return new RegistrationResource($registration);
    }

    /**
     * Display the specified resource.
     */
    public function show(Registration $registration): RegistrationResource
    {
        return new RegistrationResource($registration);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Registration $registration): RegistrationResource
    {
        $request->validate([
            'event_id' => 'required|exists:events,id',
            'user_id' => 'required|exists:users,id',
            'paid' => 'boolean'
        ]);

        $registration->user_id = $request->user_id;
        $registration->event_id = $request->event_id;
        $registration->paid = $request->paid;

        $registration->save();

        return new RegistrationResource($registration);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Registration $registration): Response
    {
        $registration->delete();

        return response()->noContent();
    }
}
