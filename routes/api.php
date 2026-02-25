<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\EraController;
use App\Http\Controllers\Api\TimelineEventController;
use App\Http\Controllers\Api\EventParticipantController;
use App\Http\Controllers\Api\MapLocationController;
use App\Http\Controllers\Api\HouseController;
use App\Http\Controllers\Api\CharacterController;
use App\Http\Controllers\Api\ArmyController;
use App\Http\Controllers\Api\DragonController;

Route::apiResource('eras', EraController::class);
Route::apiResource('timeline-events', TimelineEventController::class);
Route::apiResource('event-participants', EventParticipantController::class);
Route::apiResource('map-locations', MapLocationController::class);
Route::apiResource('houses', HouseController::class);
Route::apiResource('characters', CharacterController::class);
Route::apiResource('armies', ArmyController::class);
Route::apiResource('dragons', DragonController::class);

