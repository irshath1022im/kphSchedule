<?php

namespace Database\Factories;

use App\Models\ServiceRequest;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<ServiceRequest>
 */
class ServiceRequestFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            //
            'service_request_date' => $this->faker->dateTimeBetween('-3 month', 'now')->format('Y-m-d'),
            'client_id' => \App\Models\Client::factory(),
            'frequency' => $this->faker->randomElement(['one-time','daily', 'weekly', 'monthly']),
            'notes' => $this->faker->paragraph(),
        ];
    }
}
