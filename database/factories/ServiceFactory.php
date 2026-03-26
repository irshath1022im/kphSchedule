<?php

namespace Database\Factories;

use App\Models\Service;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Service>
 */
class ServiceFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $services = [
            'Regular Cleaning',
            'Deep Cleaning',
            'Move-In/Move-Out Cleaning',
            'Post-Construction Cleaning',
            'Office Cleaning',
            'Carpet Cleaning',
            'Window Cleaning',
            'Upholstery Cleaning',
            'Green Cleaning',
            'Special Event Cleaning',
        ];

        static $index = 0;
        $name = $services[$index % count($services)];
        $index++;

        return [
            'name' => $name,
            'description' => $this->faker->sentence(),
        ];
    }
}
