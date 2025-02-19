<?php

namespace Tests\Unit;

use App\Http\Middleware\ValidateAccessToken;
use App\Interfaces\AccessTokenGenerator;
use App\Interfaces\AccessTokenRepository;
use App\Services\UniqueLinkGeneratorService;
use Illuminate\Foundation\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Redirector;
use Illuminate\Routing\Route;
use Illuminate\Routing\RouteCollection;
use Illuminate\Routing\UrlGenerator;
use PHPUnit\Framework\TestCase;

final class ValidateAccessTokenTest extends TestCase
{
    public function testValidAccessTokenSuccess(): void
    {
        $repository = $this->createMock(AccessTokenRepository::class);
        $repository->expects($this->once())
            ->method('isValid')
            ->willReturn(true);

        $generator = $this->createMock(AccessTokenGenerator::class);

        $uniqueLinkService = new UniqueLinkGeneratorService($repository, $generator);

        $nextCalled = false;
        $next = function ($req) use (&$nextCalled) {
            $nextCalled = true;
            return new Response();
        };

        $request = Request::create('/test-route', 'GET');
        $route = new Route('GET', '/test-route/{accessToken}', []);
        $route->parameters = ['accessToken' => 'test_token_1'];
        $request->setRouteResolver(function () use ($route) {
            return $route;
        });

        $middleware = new ValidateAccessToken($uniqueLinkService);

        $response = $middleware->handle($request, $next);

        $this->assertTrue($nextCalled);
        $this->assertInstanceOf(Response::class, $response);
    }

    public function testInvalidAccessTokenFailure(): void
    {
        $app = new Application;
        $routeCollection = new RouteCollection;
        $routeCollection->add(new Route('GET', 'register', ['as' => 'register_form']));

        $urlGenerator = new UrlGenerator(
            $routeCollection,
            Request::create('/')
        );

        $app->singleton('redirect', function ($app) use ($urlGenerator) {
            return new Redirector($urlGenerator);
        });

        $app->singleton('url', function ($app) use ($urlGenerator) {
            return $urlGenerator;
        });

        Application::setInstance($app);

        $repository = $this->createMock(AccessTokenRepository::class);
        $repository->expects($this->once())
            ->method('isValid')
            ->willReturn(false);

        $generator = $this->createMock(AccessTokenGenerator::class);

        $uniqueLinkService = new UniqueLinkGeneratorService($repository, $generator);

        $nextCalled = false;
        $next = function ($req) use (&$nextCalled) {
            $nextCalled = true;
            return new Response();
        };

        $request = Request::create('/test-route', 'GET');
        $route = new Route('GET', '/test-route/{accessToken}', []);
        $route->parameters = ['accessToken' => 'test_token_1'];
        $request->setRouteResolver(function () use ($route) {
            return $route;
        });

        $middleware = new ValidateAccessToken($uniqueLinkService);

        $response = $middleware->handle($request, $next);

        $this->assertFalse($nextCalled);
        $this->assertInstanceOf(RedirectResponse::class, $response);
    }
}
