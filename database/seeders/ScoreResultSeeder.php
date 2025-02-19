<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\ScoreResult;

final class ScoreResultSeeder extends Seeder
{
    private const PHONE_NUMBER = '+1 234 567 8901';

    public function run(): void
    {
        ScoreResult::factory()
            ->state([
                'phone_number' => self::PHONE_NUMBER,
            ])
            ->count(10)
            ->create();
    }
}
