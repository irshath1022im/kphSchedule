<?php

namespace Database\Factories;

use App\Models\Maid;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Maid>
 */
class MaidFactory extends Factory
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
            'name' => $this->faker->name(),
            'email' => $this->faker->unique()->safeEmail(),
            'phone' => $this->faker->phoneNumber(),
            'address' => $this->faker->address(),
            'location' => $this->faker->randomElement(['Al Sadd', 'Al Waab', 'Al Rayyan', 'Al Gharrafa', 'Al Luqta', 'Al Wakrah', 'Al Khor', 'Al Thumama', 'Al Duhail', 'Al Markhiya', 'Al Hilal', 'Al Mirqab', 'Al Nasr', 'Al Sadd', 'Al Dafna', 'Al Muntazah', 'Al Nuaija', 'Al Hitmi', 'Al Aziziya']),
        ];
    }
}
