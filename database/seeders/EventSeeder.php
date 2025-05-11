<?php

namespace Database\Seeders;

use App\Models\Event;
use Illuminate\Database\Seeder;

class EventSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $events = [
            [
                'name' => 'Laravel Conference 2025',
                'description' => 'A conference for Laravel developers',
                'country' => 'USA',
                'date' => '2025-12-15',
                'time' => '09:00',
                'capacity' => 200,
            ],
            [
                'name' => 'PHP Summit',
                'description' => 'The biggest PHP event of the year',
                'country' => 'Germany',
                'date' => '2025-11-20',
                'time' => '10:00',
                'capacity' => 150,
            ],
            [
                'name' => 'Web Development Workshop',
                'description' => 'Learn the latest web development techniques',
                'country' => 'UK',
                'date' => '2025-10-25',
                'time' => '14:00',
                'capacity' => 50,
            ],
            [
                'name' => 'DevOps Day',
                'description' => 'A day dedicated to DevOps practices',
                'country' => 'Canada',
                'date' => '2025-12-05',
                'time' => '09:30',
                'capacity' => 100,
            ],
            [
                'name' => 'Mobile App Development',
                'description' => 'Learn to build mobile apps with Laravel',
                'country' => 'Australia',
                'date' => '2025-11-10',
                'time' => '13:00',
                'capacity' => 75,
            ],
        ];

        foreach ($events as $event) {
            Event::create($event);
        }
    }
}