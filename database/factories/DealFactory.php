<?php

namespace Database\Factories;

use App\Enums\DealStages;
use App\Models\Company;
use App\Models\Contact;
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
            'name' => fake()->word(),
            'description' => fake()->paragraph(),
            'stage' => fake()->randomElement(DealStages::values()),
            'contact_id' => fake()->randomElement(Contact::select('id')->get()->pluck('id')->toArray()),
            'owner_id' => fake()->randomElement(User::select('id')->get()->pluck('id')->toArray()),
            'deal_value' => fake()->numberBetween(1000, 10000),
            'company_id' => fake()->randomElement(Company::select('id')->get()->pluck('id')->toArray()),
        ];
    }
}
