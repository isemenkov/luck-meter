<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use App\Interfaces\AccessTokenRepository;
use App\Statuses\AccessTokenSaveStatus;
use App\Statuses\AccessTokenUpdateStatus;
use App\Statuses\AccessTokenStatus;
use App\Statuses\UserInfoStatus;
use App\Objects\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;

final class AccessToken extends Model implements AccessTokenRepository
{
    protected $fillable = [
        'user_name',
        'phone_number',
        'access_token',
        'valid_till',
        'status',
    ];

    public function getUserData(string $accessToken): User|UserInfoStatus
    {
        $token = $this->where('access_token', $accessToken)->first();

        if (!$token) {
            return UserInfoStatus::ACCESS_TOKEN_NOT_VALID;
        }

        return new User($token->user_name, $token->phone_number);
    }

    public function saveToken(string $userName, string $phoneNumber, string $accessToken): AccessTokenSaveStatus
    {
        $token = $this->where('access_token', $accessToken)->first();

        if ($token) {
            return AccessTokenSaveStatus::ALREADY_EXISTS;
        }

        $token = $this->create([
            'user_name' => $userName,
            'phone_number' => $phoneNumber,
            'access_token' => $accessToken,
            'valid_till' => Carbon::now()->addSeconds(self::VALID_TOKEN_TIME),
            'status' => AccessTokenStatus::ACTIVE,
        ]);
        $token->save();

        return AccessTokenSaveStatus::SUCCESS;
    }

    public function changeStatus(string $accessToken, AccessTokenStatus $status): AccessTokenUpdateStatus
    {
        $token = $this->where('access_token', $accessToken)->first();

        if (!$token) {
            return AccessTokenUpdateStatus::TOKEN_DOESNT_EXIST;
        }

        $token->update([
            'status' => $status->value,
        ]);

        return AccessTokenUpdateStatus::SUCCESS;
    }

    public function isValid(string $accessToken): bool
    {
        $accessToken = $this->where('access_token', $accessToken)->first();

        if ($accessToken
            && $accessToken->status === AccessTokenStatus::ACTIVE->value
            && $accessToken->valid_till > Carbon::now()
        ) {
            return true;
        }

        return false;
    }
}
