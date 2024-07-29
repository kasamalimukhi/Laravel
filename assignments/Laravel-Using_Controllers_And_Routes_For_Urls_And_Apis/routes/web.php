<?php

use App\Http\Controllers\Authcontroller;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::post("/register",[Authcontroller::class,"register"]);
Route::post("/login",[Authcontroller::class,"login"]);


