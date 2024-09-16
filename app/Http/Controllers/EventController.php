<?php

namespace App\Http\Controllers;

use App\Http\Requests\Event\EventCreateRequest;
use App\Http\Resources\EventResource;
use App\Models\Event;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use OpenApi\Attributes as OA;

class EventController extends Controller
{
    #[OA\Get(path: '/api/events', summary: 'Get collection of events', tags: ['Event'])]
    #[OA\Response(response: '200', description: 'A paginated collection of events', content: new OA\JsonContent(ref: '#/components/schemas/EventPaginatedCollection'))]
    public function index(): AnonymousResourceCollection
    {
        return EventResource::collection(Event::withCount('registrations')->paginate());
    }

    #[OA\Get(path: '/api/stores/{store}/upcoming-events', summary: 'Get collection of upcoming events at a store', tags: ['Event'])]
    #[OA\Parameter(name: 'store', description: 'The store where the upcoming events occur', in: 'path', required: true, schema: new OA\Schema(type: 'integer'))]
    #[OA\Response(response: '200', description: 'A paginated collection of upcoming events at the given store', content: new OA\JsonContent(ref: '#/components/schemas/EventPaginatedCollection'))]
    public function upcoming_events(int $store_id): AnonymousResourceCollection
    {
        return EventResource::collection(Event::where('start_time', '>', 'now()')
            ->where('store_id', '=', $store_id)
            ->withCount('registrations')
            ->paginate()
        );
    }

    #[OA\Post(path: '/api/events', summary: 'Create event', tags: ['Event'])]
    #[OA\RequestBody(ref: '#/components/requestBodies/EventCreateRequest')]
    #[OA\Response(response: '201', description: 'The created event', content: new OA\JsonContent(properties: [
        new OA\Property(property: 'data', ref: '#/components/schemas/Event', type: 'object'),
    ]))]
    #[OA\Response(response: '400', description: 'Input format is incorrect', content: new OA\JsonContent(ref: '#/components/schemas/Error'))]
    #[OA\Response(response: '422', description: 'Input data has not been validated', content: new OA\JsonContent(ref: '#/components/schemas/Error'))]
    public function store(EventCreateRequest $request): EventResource
    {
        $event = new Event;
        $event = $this->hydrateEvent($request, $event);
        $event->save();

        return new EventResource($event);
    }

    #[OA\Get(path: '/api/events/{id}', summary: 'Get event', tags: ['Event'])]
    #[OA\Parameter(name: 'id', description: 'The ID of the event', in: 'path', required: true, schema: new OA\Schema(type: 'integer'))]
    #[OA\Response(response: '200', description: 'The required event', content: new OA\JsonContent(properties: [
        new OA\Property(property: 'data', ref: '#/components/schemas/Event', type: 'object'),
    ]))]
    #[OA\Response(response: '404', description: 'No event has been found with this ID', content: new OA\JsonContent(ref: '#/components/schemas/Error'))]
    public function show(Event $event): EventResource
    {
        return new EventResource($event->load('registrations.user')->loadCount('registrations'));
    }

    #[OA\Put(path: '/api/events/{id}', summary: 'Update event', tags: ['Event'])]
    #[OA\RequestBody(ref: '#/components/requestBodies/EventCreateRequest')]
    #[OA\Parameter(name: 'id', description: 'The ID of the event', in: 'path', required: true, schema: new OA\Schema(type: 'integer'))]
    #[OA\Response(response: '200', description: 'The updated event', content: new OA\JsonContent(properties: [
        new OA\Property(property: 'data', ref: '#/components/schemas/Event', type: 'object'),
    ]))]
    #[OA\Response(response: '400', description: 'Input format is incorrect', content: new OA\JsonContent(ref: '#/components/schemas/Error'))]
    #[OA\Response(response: '422', description: 'Input data has not been validated', content: new OA\JsonContent(ref: '#/components/schemas/Error'))]
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
