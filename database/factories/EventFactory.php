<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Event>
 */
class EventFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->sentence(3),
            'description' => $this->faker->paragraph(),
            'country' => $this->faker->country(),
            'date' => $this->faker->dateTimeBetween('+1 week', '+1 year')->format('Y-m-d'),
            'time' => $this->faker->time('H:i'),
            'capacity' => $this->faker->numberBetween(10, 200),
        ];
    }
}