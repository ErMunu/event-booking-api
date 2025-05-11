<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreEventRequest;
use App\Http\Requests\UpdateEventRequest;
use App\Http\Resources\EventResource;
use App\Models\Event;
use App\Services\EventService;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;

class EventController extends Controller
{
    /**
     * @var EventService
     */
    protected $eventService;

    /**
     * EventController constructor.
     *
     * @param EventService $eventService
     */
    public function __construct(EventService $eventService)
    {
        $this->eventService = $eventService;
    }

    /**
     * Display a listing of the events.
     *
     * @param Request $request
     * @return AnonymousResourceCollection
     */
    public function index(Request $request): AnonymousResourceCollection
    {
        $country = $request->query('country');
        $perPage = $request->query('per_page', 15);
        
        $events = $this->eventService->getEvents($country, $perPage);
        
        return EventResource::collection($events);
    }

    /**
     * Store a newly created event in storage.
     *
     * @param StoreEventRequest $request
     * @return EventResource
     */
    public function store(StoreEventRequest $request): EventResource
    {
        $event = $this->eventService->createEvent($request->validated());
        return new EventResource($event);
    }

    /**
     * Display the specified event.
     *
     * @param Event $event
     * @return EventResource
     */
    public function show(Event $event): EventResource
    {
        return new EventResource($event);
    }

    /**
     * Update the specified event in storage.
     *
     * @param UpdateEventRequest $request
     * @param Event $event
     * @return EventResource
     */
    public function update(UpdateEventRequest $request, Event $event): EventResource
    {
        $event = $this->eventService->updateEvent($event, $request->validated());
        
        return new EventResource($event);
    }

    /**
     * Remove the specified event from storage.
     *
     * @param Event $event
     * @return Response
     */
    public function destroy(Event $event): Response
    {
        $this->eventService->deleteEvent($event);
        
        return response()->noContent();
    }
}