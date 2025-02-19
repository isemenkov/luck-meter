<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use App\Services\LuckCalculator;
use App\Services\UserInfoService;
use App\Services\ResultsService;

final class LuckyController extends Controller
{
    public function __construct(
        private LuckCalculator $calculator,
        private UserInfoService $userInfoService,
        private ResultsService $resultsService,
    ){
    }

    public function index(): Response|RedirectResponse
    {
        if (request()->route('access_token')) {
            session()->put('access_token', request()->route('access_token'));
        }

        return response()->view('luck-meter', [
            'score' => session()->get('score', '-'),
            'pageUrl' => sprintf("%s/%s", route('lucky_form'), session()->get('access_token', '')),
            'historyResults' => session()->get('historyResults', []),
        ]);
    }

    public function calculate(): RedirectResponse
    {
        $info = $this->userInfoService->getUserData(session()->get('access_token'));
        $result = $this->calculator->calculate(mt_rand(0, 1000));
        $this->resultsService->saveResult($info->phone, $result->result->value, $result->score);

        session()->put('score', sprintf('%s (%s points)', $result->result->value, $result->score));

        return redirect()->route('lucky_form');
    }
}
