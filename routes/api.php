<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::post('/register',[AuthController::class,'register']);
Route::post('/login',[AuthController::class,'login']);

Route::middleware('auth:sanctum')->group(function(){

Route::post('/logout',[AuthController::class,'logout']);
Route::get('/me',fn()=>auth()->user());

Route::get('/events',[EventController::class,'index']);
Route::get('/events/{id}',[EventController::class,'show']);

Route::middleware('role:organizer')->group(function(){
Route::post('/events',[EventController::class,'store']);
Route::put('/events/{id}',[EventController::class,'update']);
Route::delete('/events/{id}',[EventController::class,'destroy']);
});

Route::post('/tickets/{id}/bookings',[BookingController::class,'store']);
Route::get('/bookings',[BookingController::class,'index']);

Route::post('/bookings/{id}/payment',[PaymentController::class,'pay']);

});