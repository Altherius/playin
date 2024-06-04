<?php

namespace App\Http\Controllers;

use App\Http\Requests\Event\EventCreateRequest;
use App\Http\Resources\EventResource;
use App\Models\Event;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class EventController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): AnonymousResourceCollection
    {
        return EventResource::collection(Event::withCount('registrations')->paginate());
    }

    public function upcoming_events(int $store_id): AnonymousResourceCollection
    {
        return EventResource::collection(Event::where('start_time', '>', 'now()')
            ->where('store_id', '=', $store_id)
            ->withCount('registrations')
            ->paginate()
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(EventCreateRequest $request): EventResource
    {
        $event = new Event();
        $event = $this->hydrateEvent($request, $event);
        $event->save();

        return new EventResource($event);
    }

    /**
     * Display the specified resource.
     */
    public function show(Event $event): EventResource
    {
        return new EventResource($event->load('registrations.user')->loadCount('registrations'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(EventCreateRequest $request, Event $event): EventResource
    {
        $event = $this->hydrateEvent($request, $event);
        $event->save();

        return new EventResource($event);
    }

    private function hydrateEvent(EventCreateRequest $request, Event $event): Event
    {
        $event->name = $request->name;
        $event->store_id = $request->store_id;
        $event->start_time = $request->start_time;
        $event->end_time = $request->end_time;
        $event->max_capacity = $request->max_capacity;
        $event->price = $request->price;

        return $event;
    }
}
