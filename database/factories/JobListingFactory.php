<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\JobListing>
 */
class JobListingFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => fake()->jobTitle(),
            'description' => fake()->realText(1000),
            'email' => fake()->email(),
            'company_name' => fake()->company(),
            'number_impression' => fake()->numberBetween(1, 20),
            'number_applies' => fake()->numberBetween(1, 20),
            'number_views' => fake()->numberBetween(1, 20),
            'created_by' => fake()->numberBetween(1, 2),
            'status' => 'active',
        ];
    }
}
