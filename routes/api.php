<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\MemberController;
use App\Http\Controllers\Api\EventController;
use App\Http\Controllers\Api\SponsorController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
| Buradaki rotalar otomatik olarak RouteServiceProvider tarafından
| "/api" prefix'i ile gruplanır. Ornegin: /api/members
*/

Route::get('/', function () {
    return response()->json(['status' => 'ok']);
});

Route::apiResource('members', MemberController::class);
Route::apiResource('events', EventController::class);
Route::apiResource('sponsors', SponsorController::class);
Route::apiResource('contacts', \App\Http\Controllers\Api\ContactController::class);
Route::get('contacts/stats', [\App\Http\Controllers\Api\ContactController::class, 'stats']);
