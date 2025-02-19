<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use App\Services\ResultsService;
use App\Services\UserInfoService;
use App\Interfaces\ResultsRepository;

final class ResultsHistoryController extends Controller
{
    public function __construct(
        private ResultsService $resultsService,
        private UserInfoService $userInfoService
    ) {
    }

    public function lastResults(): RedirectResponse
    {
        $info = $this->userInfoService->getUserData(session()->get('access_token'));
        $results = $this->resultsService->getResults($info->phone, ResultsRepository::HISTORY_RESULTS_LIMIT);

        session()->flash('historyResults', $results);

        return redirect()->route('lucky_form');
    }
}
