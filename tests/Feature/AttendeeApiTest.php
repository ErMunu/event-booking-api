<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AttendeeApiTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test creating an attendee.
     */
    public function test_can_create_attendee(): void
    {
        $attendeeData = [
            'name' => 'Test Attendee',
            'email' => 'test@example.com',
            'phone' => '1234567890',
        ];

        // Make request to create attendee
        $response = $this->postJson('/api/attendees', $attendeeData);

        // Assert response
        $response->assertStatus(201)
            ->assertJsonStructure([
                'data' => [
                    'id',
                    'name',
                    'email',
                    'phone',
                    'created_at',
                    'updated_at',
                ],
            ]);

        // Assert data was stored in the database
        $this->assertDatabaseHas('attendees', [
            'name' => 'Test Attendee',
            'email' => 'test@example.com',
            'phone' => '1234567890',
        ]);
    }

    /**
     * Test validation for creating an attendee.
     */
    public function test_attendee_validation(): void
    {
        // Missing required fields
        $response = $this->postJson('/api/attendees', []);

        // Assert validation errors
        $response->assertStatus(422)
            ->assertJsonValidationErrors(['name', 'email', 'phone']);

        // Invalid email
        $response = $this->postJson('/api/attendees', [
            'name' => 'Test Attendee',
            'email' => 'not-an-email',
            'phone' => '1234567890',
        ]);

        // Assert validation errors
        $response->assertStatus(422)
            ->assertJsonValidationErrors(['email']);
    }
}