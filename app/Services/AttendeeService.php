<?php

namespace App\Services;

use App\Models\Attendee;

class AttendeeService
{
    /**
     * Create a new attendee.
     *
     * @param array $data
     * @return Attendee
     */
    public function createAttendee(array $data): Attendee
    {
        return Attendee::create($data);
    }

    /**
     * Find an attendee by email or create a new one.
     *
     * @param array $data
     * @return Attendee
     */
    public function findOrCreateAttendee(array $data): Attendee
    {
        return Attendee::firstOrCreate(
            ['email' => $data['email']],
            [
                'name' => $data['name'],
                'phone' => $data['phone'],
            ]
        );
    }
}