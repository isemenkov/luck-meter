<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegisterRequest;
use App\Services\UniqueLinkGeneratorService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;

final class RegisterController extends Controller
{
    public function index(): Response
    {
        return response()->view('register');
    }

    public function register(RegisterRequest $request, UniqueLinkGeneratorService $generator): RedirectResponse
    {
        $accessToken = $generator->generate($request->validated('username'), $request->validated('phonenumber'));
        session()->forget('score');
        session()->put('access_token', $accessToken);

        return redirect()->route('lucky_form');
    }
}
