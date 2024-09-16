<?php

namespace App\Http\Controllers;

use App\Http\Requests\Registration\RegistrationCreateRequest;
use App\Http\Requests\Registration\RegistrationUpdateRequest;
use App\Http\Resources\RegistrationResource;
use App\Models\Event;
use App\Models\Registration;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;
use OpenApi\Attributes as OA;
use Symfony\Component\HttpKernel\Exception\UnprocessableEntityHttpException;

class RegistrationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    #[OA\Get(path: '/api/registrations', summary: 'Get collection of registrations', tags: ['Registration'])]
    #[OA\Response(response: '200', description: 'A paginated collection of registrations', content: new OA\JsonContent(ref: '#/components/schemas/RegistrationPaginatedCollection'))]
    public function index(): AnonymousResourceCollection
    {
        return RegistrationResource::collection(Registration::paginate());
    }

    /**
     * Store a newly created resource in storage.
     */
    #[OA\Post(path: '/api/registrations', summary: 'Create registration', tags: ['Registration'])]
    #[OA\RequestBody(ref: '#/components/requestBodies/RegistrationCreateRequest')]
    #[OA\Response(response: '201', description: 'The created registration', content: new OA\JsonContent(properties: [
        new OA\Property(property: 'data', ref: '#/components/schemas/Registration', type: 'object'),
    ]))]
    #[OA\Response(response: '400', description: 'Input format is incorrect', content: new OA\JsonContent(ref: '#/components/schemas/Error'))]
    #[OA\Response(response: '422', description: 'Input data has not been validated', content: new OA\JsonContent(ref: '#/components/schemas/Error'))]
    public function store(RegistrationCreateRequest $request): RegistrationResource
    {
        $event = Event::withCount('registrations')->find($request->event_id);
        if ($event->registrations_count >= $event->max_capacity) {
            throw new UnprocessableEntityHttpException('This event is already full');
        }

        $registration = new Registration;
        $registration->user_id = $request->user_id;
        $registration->event_id = $request->event_id;

        $registration->save();

        return new RegistrationResource($registration);
    }

    #[OA\Get(path: '/api/registrations/{id}', summary: 'Get registration', tags: ['Registration'])]
    #[OA\Parameter(name: 'id', description: 'The ID of the registration', in: 'path', required: true, schema: new OA\Schema(type: 'integer'))]
    #[OA\Response(response: '200', description: 'The required registration', content: new OA\JsonContent(properties: [
        new OA\Property(property: 'data', ref: '#/components/schemas/Registration', type: 'object'),
    ]))]
    #[OA\Response(response: '404', description: 'No registration has been found with this ID', content: new OA\JsonContent(ref: '#/components/schemas/Error'))]
    public function show(Registration $registration): RegistrationResource
    {
        return new RegistrationResource($registration);
    }

    #[OA\Put(path: '/api/registrations/{id}', summary: 'Update registration', tags: ['Registration'])]
    #[OA\RequestBody(ref: '#/components/requestBodies/RegistrationUpdateRequest')]
    #[OA\Parameter(name: 'id', description: 'The ID of the registration', in: 'path', required: true, schema: new OA\Schema(type: 'integer'))]
    #[OA\Response(response: '200', description: 'The updated registration', content: new OA\JsonContent(properties: [
        new OA\Property(property: 'data', ref: '#/components/schemas/Registration', type: 'object'),
    ]))]
    #[OA\Response(response: '400', description: 'Input format is incorrect', content: new OA\JsonContent(ref: '#/components/schemas/Error'))]
    #[OA\Response(response: '422', description: 'Input data has not been validated', content: new OA\JsonContent(ref: '#/components/schemas/Error'))]
    public function update(RegistrationUpdateRequest $request, Registration $registration): RegistrationResource
    {
        $registration->user_id = $request->user_id;
        $registration->event_id = $request->event_id;
        $registration->paid = $request->paid;

        $registration->save();

        return new RegistrationResource($registration);
    }

    #[OA\Delete(path: '/api/registrations/{id}', summary: 'Delete registration', tags: ['Registration'])]
    #[OA\Parameter(name: 'id', description: 'The ID of the registration', in: 'path', required: true, schema: new OA\Schema(type: 'integer'))]
    #[OA\Response(response: '204', description: 'Registration deleted successfully')]
    public function destroy(Registration $registration): Response
    {
        $registration->delete();

        return response()->noContent();
    }
}
