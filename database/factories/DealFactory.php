<?php

namespace Database\Factories;

use App\Enums\DealStages;
use App\Models\Customer;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Deal>
 */
class DealFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'description' => fake()->paragraph(),
            'stage' => fake()->randomElement(DealStages::values()),
            'customer_id' => fake()->randomElement(Customer::select('id')->get()->pluck('id')->toArray()),
            'owner_id' => fake()->randomElement(User::select('id')->get()->pluck('id')->toArray()),
            'deal_value' => fake()->numberBetween(1000, 10000),
        ];
    }
}
