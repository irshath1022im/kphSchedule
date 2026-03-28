<?php

namespace Database\Factories;

use App\Models\MaidAssignment;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<MaidAssignment>
 */
class MaidAssignmentFactory extends Factory
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
                'date' => $this->faker->date(),
                'maid_id' => \App\Models\Maid::factory(),
                'service_request_period_id' => $this->faker->numberBetween(1, 20), // Assuming you have 20 service request periods
                'notes' => $this->faker->sentence(),
        ];
    }
}
