<?php

namespace App\Services;

use App\Models\Event;
use Illuminate\Pagination\LengthAwarePaginator;

class EventService
{
    /**
     * Get a paginated list of events with optional filtering by country.
     *
     * @param string|null $country
     * @param int $perPage
     * @return LengthAwarePaginator
     */
    public function getEvents(?string $country = null, int $perPage = 15): LengthAwarePaginator
    {
        $query = Event::query();
        
        if ($country) {
            $query->where('country', $country);
        }
        
        return $query->latest()->paginate($perPage);
    }

    /**
     * Create a new event.
     *
     * @param array $data
     * @return Event
     */
    public function createEvent(array $data): Event
    {
        return Event::create($data);
    }

    /**
     * Update an existing event.
     *
     * @param Event $event
     * @param array $data
     * @return Event
     */
    public function updateEvent(Event $event, array $data): Event
    {
        $event->update($data);
        return $event;
    }

    /**
     * Delete an event.
     *
     * @param Event $event
     * @return bool
     */
    public function deleteEvent(Event $event): bool
    {
        return $event->delete();
    }
}