<?php
/**
 * Vercel PHP Runtime Entry Point
 */

// Define Laravel paths
define('LARAVEL_START', microtime(true));

// Set the path to the Laravel application
$laravelPath = __DIR__ . '/hob';

// Change to the Laravel directory
chdir($laravelPath);

// Load Laravel's bootstrap
require __DIR__ . '/hob/vendor/autoload.php';

$app = require_once __DIR__ . '/hob/bootstrap/app.php';

// Handle the request
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);

$response = $kernel->handle(
    $request = Illuminate\Http\Request::capture()
)->send();

$kernel->terminate($request, $response);
