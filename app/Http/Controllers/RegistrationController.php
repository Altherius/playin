<?php

namespace App\Http\Controllers;

use App\Http\Requests\Registration\RegistrationCreateRequest;
use App\Http\Requests\Registration\RegistrationUpdateRequest;
use App\Http\Resources\RegistrationResource;
use App\Models\Event;
use App\Models\Registration;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;
use Symfony\Component\HttpKernel\Exception\UnprocessableEntityHttpException;

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
    public function store(RegistrationCreateRequest $request): RegistrationResource
    {
        $event = Event::withCount('registrations')->find($request->event_id);
        if ($event->registrations_count >= $event->max_capacity) {
            throw new UnprocessableEntityHttpException('This event is already full');
        }

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
    public function update(RegistrationUpdateRequest $request, Registration $registration): RegistrationResource
    {
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
