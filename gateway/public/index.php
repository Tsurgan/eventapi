<?php

use App\Dispatcher\DispatcherInterface;
use App\Dispatcher\HttpDispatcher;
use App\Dispatcher\GRPCDispatcher;
use Spiral\RoadRunner\Environment;

define('LARAVEL_START', microtime(true));

// Determine if the application is in maintenance mode...
if (file_exists($maintenance = __DIR__.'/../storage/framework/maintenance.php')) {
    require $maintenance;
}

// Register the Composer autoloader...
require __DIR__.'/../vendor/autoload.php';

/**
 * Collect all dispatchers.
 *
 * @var DispatcherInterface[] $dispatchers
 */
$dispatchers = [
    new HttpDispatcher(),
    new GRPCDispatcher(),
];

// Create environment
$env = Environment::fromGlobals();

// Execute dispatcher that can serve the request
    foreach ($dispatchers as $dispatcher) {
        if ($dispatcher->canServe($env)) {
            $dispatcher->serve();
        }
    }
