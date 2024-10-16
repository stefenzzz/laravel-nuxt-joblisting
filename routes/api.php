<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\JobListingController;
use App\Http\Controllers\UserController;
use App\Models\JobListing;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    // eager load role
    $request->user()->load('role');
    return $request->user();
})->middleware('auth:sanctum');


Route::post('/login',[AuthController::class,'login']);
Route::post('/register',[AuthController::class,'register']);

Route::post('/logout',[AuthController::class,'logout'])->middleware('auth:sanctum');


Route::apiResource('jobs', JobListingController::class)->only(['index', 'show']);
Route::post('/jobs/views/{id}',[JobListingController::class,'updateViews']);
Route::post('/jobs/apply/{id}',[JobListingController::class,'submitApplication']);
Route::post('/jobs/impressions/{id}',[JobListingController::class,'updateImpressions']);

Route::middleware( ['auth:sanctum', 'roles:admin,company' ] )->group(function () {
    Route::apiResource('jobs', JobListingController::class)->except(['index', 'show']);
});

Route::middleware( ['auth:sanctum', 'roles:admin' ] )->group(function () {
    Route::apiResource('users', UserController::class);
});
