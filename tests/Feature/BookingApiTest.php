<?php

namespace Tests\Feature;

use App\Models\Attendee;
use App\Models\Booking;
use App\Models\Event;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BookingApiTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test creating a booking.
     */
    public function test_can_create_booking(): void
    {
        // Create an event and an attendee
        $event = Event::factory()->create(['capacity' => 10]);
        $attendee = Attendee::factory()->create();

        $bookingData = [
            'event_id' => $event->id,
            'attendee_id' => $attendee->id,
        ];

        // Make request to create booking
        $response = $this->postJson('/api/bookings', $bookingData);

        // Assert response
        $response->assertStatus(201)
            ->assertJsonStructure([
                'data' => [
                    'id',
                    'event',
                    'attendee',
                    'created_at',
                    'updated_at',
                ],
            ]);

        // Assert data was stored in the database
        $this->assertDatabaseHas('bookings', [
            'event_id' => $event->id,
            'attendee_id' => $attendee->id,
        ]);
    }

    /**
     * Test preventing duplicate bookings.
     */
    public function test_prevents_duplicate_bookings(): void
    {
        // Create an event, an attendee, and a booking
        $event = Event::factory()->create(['capacity' => 10]);
        $attendee = Attendee::factory()->create();
        
        Booking::create([
            'event_id' => $event->id,
            'attendee_id' => $attendee->id,
        ]);

        $bookingData = [
            'event_id' => $event->id,
            'attendee_id' => $attendee->id,
        ];

        // Make request to create duplicate booking
        $response = $this->postJson('/api/bookings', $bookingData);

        // Assert response
        $response->assertStatus(422)
            ->assertJsonPath('message', 'The attendee is already booked for this event.');
    }

    /**
     * Test preventing overbooking.
     */
    public function test_prevents_overbooking(): void
    {
        // Create an event with capacity 1
        $event = Event::factory()->create(['capacity' => 1]);
        
        // Create two attendees
        $attendee1 = Attendee::factory()->create();
        $attendee2 = Attendee::factory()->create();
        
        // Book the first attendee
        Booking::create([
            'event_id' => $event->id,
            'attendee_id' => $attendee1->id,
        ]);

        $bookingData = [
            'event_id' => $event->id,
            'attendee_id' => $attendee2->id,
        ];

        // Make request to create booking that would exceed capacity
        $response = $this->postJson('/api/bookings', $bookingData);

        // Assert response
        $response->assertStatus(422)
            ->assertJsonPath('message', 'The event is fully booked.');
    }
}