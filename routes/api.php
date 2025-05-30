<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V1\BestSellerController;
use App\Http\Controllers\Api\V1\HealthCheckController;
use App\Http\Controllers\Api\V1\JobController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::get('/health', [HealthCheckController::class, 'check']);

Route::prefix('/v1')->group(function () {
    Route::get('/bestsellers', [BestSellerController::class, 'index']);
    Route::post('/start-job', [JobController::class, 'startJob']);
    Route::get('/job-status/{jobId}', [JobController::class, 'checkJobStatus']);
});

