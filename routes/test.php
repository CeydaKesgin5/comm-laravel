<?php

use Illuminate\Support\Facades\Route;

Route::get('/test-contact', function () {
    return response()->json([
        'status' => 'success',
        'message' => 'Test endpoint is working!',
        'cors' => [
            'allowed_origins' => config('cors.allowed_origins'),
            'allowed_methods' => config('cors.allowed_methods'),
            'allowed_headers' => config('cors.allowed_headers'),
        ]
    ]);
});
