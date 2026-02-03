<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Health check endpoint
Route::get('/health', function () {
    return response()->json([
        'status' => 'ok',
        'timestamp' => now()->toISOString(),
        'database' => 'connected'
    ]);
});

// Basic test endpoint
Route::get('/test', function () {
    return response()->json([
        'message' => 'Laravel is working!',
        'env' => app()->environment(),
        'database_connection' => config('database.default')
    ]);
});
