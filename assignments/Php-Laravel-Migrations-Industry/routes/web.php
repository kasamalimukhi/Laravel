<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\mycontroller;
use App\Http\Controllers\ApiController;
use App\Http\Controllers\singlecontroller;


Route::get('/', function () {
    return view('welcome');
});
Route::get('/dashboard', function () {
    return view('dashboard');
});
Route::get('/home', function () {
    return view('home');
});
Route::get('/profile', function () {
    return view('profile');
});
Route::get('/about', function () {
    return view('about');
});
Route::get('/master', function () {
    return view('master');
});

Route::get('/cities', [ApiController::class, 'getallcities']);
Route::get('/cities/create', [ApiController::class, 'showview'])->name('addcity.create');
Route::post('/cities/store', [ApiController::class, 'addcities'])->name('addcity.store');
Route::get('/citystate', [ApiController::class, 'getallcitiesstate']);
Route::get('/mmm', [mycontroller::class, 'index']);
Route::get('/nnn', singlecontroller::class);