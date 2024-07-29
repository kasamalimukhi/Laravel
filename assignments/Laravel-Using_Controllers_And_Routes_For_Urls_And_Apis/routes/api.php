<?php

use App\Http\Controllers\Authcontroller;
use App\Http\Controllers\PostController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('/register', [Authcontroller::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::middleware("auth:sanctum")->group(function (){
    Route::get("/posts",[PostController::class,"index"]);
    Route::post("/post",[PostController::class,"createPost"]);
});