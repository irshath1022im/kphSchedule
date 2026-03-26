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
            'client_id' => \App\Models\Client::factory(),
            'service_id' => \App\Models\Service::factory(),
            'service_request_date' => $this->faker->dateTimeBetween('-3 month', 'now')->format('Y-m-d'),
            'service_request_time' => $this->faker->time(),
            'service_end_date' => $this->faker->dateTimeBetween('-1 month', '+2 month')->format('Y-m-d'),
            'service_end_time' => $this->faker->time(),
            'status' => $this->faker->randomElement(['pending', 'completed', 'cancelled']),
            'notes' => $this->faker->paragraph(),
            'service_location' => $this->faker->address(),
        ];
    }
}
