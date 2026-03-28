<?php

namespace Database\Factories;

use App\Models\ServiceRequest;
use App\Models\ServiceRequestPeriod;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<ServiceRequestPeriod>
 */
class ServiceRequestPeriodFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            //App\Models\ServiceRequest::factory(),
            'request_id' => $this->faker->numberBetween(1, 20), // Assuming you have 20 service requests
            'service_id' => $this->faker->numberBetween(1, 10), // Assuming you have 10 services
            'start_date' => ServiceRequest::factory()->create()->service_request_date,
            'day_of_week' => $this->faker->numberBetween(1, 7), // 1 for Monday, 7 for Sunday
            'start_time' => $this->faker->time(),
            'duration_hours' => $this->faker->randomFloat(1, 0, 8),
            'status' => $this->faker->randomElement(['pending', 'completed', 'cancelled']),
        ];
    }
}
