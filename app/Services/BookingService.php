<?php

namespace App\Services;

use App\Models\Booking;
use App\Models\Event;
use App\Models\Attendee;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class BookingService
{
    /**
     * Create a new booking.
     *
     * @param array $data
     * @return Booking
     * @throws \Exception
     */
    public function createBooking(array $data): Booking
    {
        $event = Event::findOrFail($data['event_id']);
        $attendee = Attendee::findOrFail($data['attendee_id']);
        
        // Check if the event is fully booked
        if ($event->isFullyBooked()) {
            throw new \Exception('The event is fully booked.');
        }
        
        // Check if the attendee is already booked for this event
        if ($attendee->isBookedForEvent($event->id)) {
            throw new \Exception('The attendee is already booked for this event.');
        }
        
        return Booking::create([
            'event_id' => $event->id,
            'attendee_id' => $attendee->id,
        ]);
    }
}