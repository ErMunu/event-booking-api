<?php

namespace Tests\Feature;

use App\Models\Event;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class EventApiTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test listing events.
     */
    public function test_can_list_events(): void
    {
        // Create some events
        Event::factory()->count(5)->create();

        // Make request to list events
        $response = $this->getJson('/api/events');

        // Assert response
        $response->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    '*' => [
                        'id',
                        'name',
                        'description',
                        'country',
                        'date',
                        'time',
                        'capacity',
                        'available_spots',
                        'created_at',
                        'updated_at',
                    ],
                ],
                'links',
                'meta',
            ]);
    }

    /**
     * Test filtering events by country.
     */
    public function test_can_filter_events_by_country(): void
    {
        // Create events with different countries
        Event::factory()->create(['country' => 'USA']);
        Event::factory()->create(['country' => 'Canada']);
        Event::factory()->create(['country' => 'USA']);

        // Make request to list events filtered by country
        $response = $this->getJson('/api/events?country=USA');

        // Assert response
        $response->assertStatus(200)
            ->assertJsonCount(2, 'data');
    }

    /**
     * Test creating an event.
     */
    public function test_can_create_event(): void
    {
        $eventData = [
            'name' => 'Test Event',
            'description' => 'This is a test event',
            'country' => 'Test Country',
            'date' => '2023-12-31',
            'time' => '14:00',
            'capacity' => 100,
        ];

        // Make request to create event
        $response = $this->postJson('/api/events', $eventData);

        // Assert response
        $response->assertStatus(201)
            ->assertJsonStructure([
                'data' => [
                    'id',
                    'name',
                    'description',
                    'country',
                    'date',
                    'time',
                    'capacity',
                    'available_spots',
                    'created_at',
                    'updated_at',
                ],
            ]);

        // Assert data was stored in the database
        $this->assertDatabaseHas('events', [
            'name' => 'Test Event',
            'country' => 'Test Country',
        ]);
    }

    /**
     * Test showing an event.
     */
    public function test_can_show_event(): void
    {
        // Create an event
        $event = Event::factory()->create();

        // Make request to show event
        $response = $this->getJson("/api/events/{$event->id}");

        // Assert response
        $response->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    'id',
                    'name',
                    'description',
                    'country',
                    'date',
                    'time',
                    'capacity',
                    'available_spots',
                    'created_at',
                    'updated_at',
                ],
            ]);
    }

    /**
     * Test updating an event.
     */
    public function test_can_update_event(): void
    {
        // Create an event
        $event = Event::factory()->create();

        $updateData = [
            'name' => 'Updated Event Name',
            'capacity' => 200,
        ];

        // Make request to update event
        $response = $this->putJson("/api/events/{$event->id}", $updateData);

        // Assert response
        $response->assertStatus(200)
            ->assertJsonPath('data.name', 'Updated Event Name')
            ->assertJsonPath('data.capacity', 200);

        // Assert data was updated in the database
        $this->assertDatabaseHas('events', [
            'id' => $event->id,
            'name' => 'Updated Event Name',
            'capacity' => 200,
        ]);
    }

    /**
     * Test deleting an event.
     */
    public function test_can_delete_event(): void
    {
        // Create an event
        $event = Event::factory()->create();

        // Make request to delete event
        $response = $this->deleteJson("/api/events/{$event->id}");

        // Assert response
        $response->assertStatus(204);

        // Assert data was deleted from the database
        $this->assertDatabaseMissing('events', [
            'id' => $event->id,
        ]);
    }
}