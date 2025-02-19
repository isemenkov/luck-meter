<?php

namespace Database\Factories;

use App\Statuses\LuckResultStatus;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ScoreResult>
 */
final class ScoreResultFactory extends Factory
{
    /**
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'phone_number' => fake()->phoneNumber(),
            'result' => fake()->randomElement([
                LuckResultStatus::WIN->value,
                LuckResultStatus::LOSE->value
            ]),
            'score' => fake()->numberBetween(0, 1000),
        ];
    }
}
