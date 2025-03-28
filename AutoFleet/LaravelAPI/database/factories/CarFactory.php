<?php

namespace Database\Factories;

use App\Models\Car;
use Illuminate\Database\Eloquent\Factories\Factory;

class CarFactory extends Factory
{
    protected $model = Car::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'type' => fake()->word(),
            'price_per_day' => fake()->numberBetween(10, 100),
            'doors' => fake()->numberBetween(2, 5),
            'bags' => fake()->numberBetween(1, 4),
            'seats' => fake()->numberBetween(2, 7),
            'airconditioning' => fake()->boolean(),
            'engine_type' => fake()->word(),
            'is_unlimited_mileage' => fake()->boolean(),
            'refundable_security_deposit' => fake()->randomFloat(2, 0, 1000),
            'transmission' => fake()->word(),
            'description' => fake()->paragraph(),
            'image_path' => fake()->word(),
            'Theft_Protection' => fake()->word(),
            'better_to_know' => fake()->sentence(),
            'cancellation_policy' => fake()->sentence(),
            'collision_damage_waiver' => fake()->word(),
            'fuel_policy' => fake()->word(),
            'included_insurance' => fake()->word(),
            'roadside_assistance' => fake()->word(),
            'third_party_liability' => fake()->word(),
        ];
    }
}
