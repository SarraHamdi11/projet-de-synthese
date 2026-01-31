<?php
/**
 * Vercel Entry Point for Laravel Application
 */

// Set the working directory to the Laravel app
chdir(__DIR__ . '/hob');

// Load Laravel's bootstrap
require __DIR__ . '/hob/vendor/autoload.php';

$app = require_once __DIR__ . '/hob/bootstrap/app.php';

// Handle the request
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);

$response = $kernel->handle(
    $request = Illuminate\Http\Request::capture()
)->send();

$kernel->terminate($request, $response);
