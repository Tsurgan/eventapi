<?php

use Illuminate\Foundation\Application;

use GRPC\TaskStatus\TaskStatusServiceInterface;
use App\Services\GRPCMessenger;
use Spiral\RoadRunner\GRPC\Invoker;
use Spiral\RoadRunner\GRPC\Server;
use Spiral\RoadRunner\Worker;
use Illuminate\Contracts\Console\Kernel;

//use Illuminate\Foundation\Application;

define('LARAVEL_START', microtime(true));

// Determine if the application is in maintenance mode...
if (file_exists($maintenance = __DIR__.'/../storage/framework/maintenance.php')) {
    require $maintenance;
}

// Register the Composer autoloader...
require __DIR__.'/../vendor/autoload.php';

// Bootstrap Laravel and handle the request...
/** @var Application $app */
$app = require_once __DIR__.'/../bootstrap/app.php';

$server = new Server(new Invoker(), [
    'debug' => false, // optional (default: false)
]);

$server->registerService(TaskStatusServiceInterface::class, new GRPCMessenger());

//$server->serve(Worker::create());
        $app = require Application::inferBasePath().'/bootstrap/app.php';
$app->make(Kernel::class)->bootstrap();

try {
    $server->serve(Worker::create());
} catch (Throwable $e) {
    error_log($e->getMessage());
}
