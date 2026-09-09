<?php

namespace App\Dispatcher;

use App\RoadRunnerMode;
use Nyholm\Psr7\Factory\Psr17Factory;
use Illuminate\Foundation\Application;
use Nyholm\Psr7\Response;
use Spiral\RoadRunner\EnvironmentInterface;
use Spiral\RoadRunner\Http\PSR7Worker;
use Spiral\RoadRunner\Worker;
use Illuminate\Http\Request as LaravelRequest;

use Illuminate\Contracts\Http\Kernel;
use Symfony\Bridge\PsrHttpMessage\Factory\PsrHttpFactory;
use Symfony\Bridge\PsrHttpMessage\Factory\HttpFoundationFactory;


final class HttpDispatcher implements DispatcherInterface
{
    public function canServe(EnvironmentInterface $env): bool
    {
        return $env->getMode() === RoadRunnerMode::Http->value;
    }

    public function serve(): void
    {
        // Bootstrap Laravel and handle the request...
        /** @var Application $app */
        $app = require_once dirname(__DIR__).'/../bootstrap/app.php';

        if (env('RR_MODE')) {
            $psrHttpFactory = new PsrHttpFactory();
            $HttpFoundationFactory = new HttpFoundationFactory();
            $Psr17Factory = new Psr17Factory();
            $worker = new PSR7Worker(Worker::create(), $Psr17Factory, $Psr17Factory, $Psr17Factory);

            $kernel = $app->make(Kernel::class);

            while ($req = $worker->waitRequest()) {
                try {
                    //receive the symfony request
                    $symfonyRequest = $HttpFoundationFactory->createRequest($req);
                    //make it into laravel request
                    $laravelRequest = LaravelRequest::createFromBase($symfonyRequest);
                    //receive laravel response
                    $response = $kernel->handle($laravelRequest);
                    //make it into psr response
                    $psr7Response = $psrHttpFactory->createResponse($response);

                    $worker->respond($psr7Response);

                    $kernel->terminate($laravelRequest, $response);
                } catch (\Throwable $e) {
                    $worker->respond(new Response(500, [], $e->getMessage()));
                }
            }
        } else {
            $app->handleRequest(LaravelRequest::capture());
        }
    }
}