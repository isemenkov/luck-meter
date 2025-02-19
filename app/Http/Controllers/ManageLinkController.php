<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use App\Services\UniqueLinkGeneratorService;
use App\Services\UserInfoService;
use App\Objects\User;
use App\Statuses\UserInfoStatus;

final class ManageLinkController extends Controller
{
    public function __construct(
        private UserInfoService $userInfoService,
        private UniqueLinkGeneratorService $linkService
    ) {
    }

    public function index(): RedirectResponse
    {
        return match(true) {
            request()->has('generateNewLink') => $this->generateNewLink(),
            request()->has('deactivateCurrentLink') => $this->deactivateCurrentLink(),
            default => redirect()->route('lucky_form'),
        };
    }

    private function generateNewLink(): RedirectResponse
    {
        $currentAccessToken = session()->get('access_token', '');
        $info = $this->userInfoService->getUserData($currentAccessToken);
        if ($info instanceof User) {
            $accessToken = $this->linkService->generate($info->name, $info->phone);
            session()->put('access_token', $accessToken);

            return redirect()->route('lucky_form');
        }

        return match($info) {
            UserInfoStatus::ACCESS_TOKEN_NOT_VALID => redirect()->route('register_form'),
        };
    }

    private function deactivateCurrentLink(): RedirectResponse
    {
        $currentAccessToken = session()->get('access_token', '');
        $this->linkService->deactivateAccessToken($currentAccessToken);
        session()->forget('access_token');

        return redirect()->route('register_form');
    }
}
