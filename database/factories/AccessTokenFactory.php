<?php

namespace Database\Factories;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;
use App\Interfaces\AccessTokenRepository;
use App\Statuses\AccessTokenStatus;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\AccessToken>
 */
final class AccessTokenFactory extends Factory
{
    /**
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_name' => fake()->userName(),
            'phone_number' => fake()->phoneNumber(),
            'access_token' => substr(md5(fake()->text()), 0, 100),
            'valid_till' => Carbon::now()->addSeconds(AccessTokenRepository::VALID_TOKEN_TIME),
            'status' => AccessTokenStatus::ACTIVE,
        ];
    }
}
