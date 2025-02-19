<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Services\UniqueLinkGeneratorService;

final class ValidateAccessToken
{
    public function __construct(
        private UniqueLinkGeneratorService $generator
    ) {
    }

    /**
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response|RedirectResponse
    {
        $accessToken = $request->route('accessToken') ?: session()->get('access_token', '');

        if (!$this->generator->isValid($accessToken)) {
            return redirect()->route('register_form');
        }

        return $next($request);
    }
}
