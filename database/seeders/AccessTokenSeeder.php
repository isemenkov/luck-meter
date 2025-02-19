<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\AccessToken;
use App\Interfaces\AccessTokenRepository;
use App\Statuses\AccessTokenStatus;

final class AccessTokenSeeder extends Seeder
{
    private const USER_NAME = 'user';
    private const USER_NAME2 = 'user2';
    private const PHONE_NUMBER = '+44 20 1234 5678';
    private const PHONE_NUMBER2 = '+44 20 1234 5679';
    private const EXISTS_ACCESS_TOKEN = 'e6fee5e2fc738d7c7ed4f7cf8b4c351b';
    private const NOT_VALID_ACCESS_TOKEN = '80243ac57c23d529193b5fbff8a58a30';

    public function run(): void
    {
        AccessToken::create([
            'user_name' => self::USER_NAME2,
            'phone_number' => self::PHONE_NUMBER2,
            'access_token' => self::NOT_VALID_ACCESS_TOKEN,
            'valid_till' => Carbon::now()->subSeconds(1),
            'status' => AccessTokenStatus::ACTIVE,
        ]);

        AccessToken::create([
            'user_name' => self::USER_NAME,
            'phone_number' => self::PHONE_NUMBER,
            'access_token' => self::EXISTS_ACCESS_TOKEN,
            'valid_till' => Carbon::now()->addSeconds(AccessTokenRepository::VALID_TOKEN_TIME),
            'status' => AccessTokenStatus::ACTIVE,
        ]);
    }
}
