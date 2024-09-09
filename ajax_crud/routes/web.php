<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProjectController;

Route::get('/', function () {
    return view('welcome');
});

// Route::view('/home','home')->middleware('checkone');
// Route::view('/about','aboute');
// Route::view('/contact','contact');

// middleware group route..
Route::middleware('checkone')->group(function(){
    Route::view('/home','home');
    Route::view('/about','aboute');
    Route::view('/contact','contact'); 
});


// Custom fetch route
// Route::get('/projects/fetch', [ProjectController::class, 'fetchProjects'])->name('projects.fetch');
// Route::post('projects/export-projects', [ProjectController::class, 'exportProjects'])->name('projects.export');
// Route::post('projects/import-projects', [ProjectController::class, 'importProjects'])->name('projects.import.projects');
// Route::get('projects/export-pdf', [ProjectController::class, 'exportProjectsPdf'])->name('projects.export.pdf');
// Route::get('/projects/search', [ProjectController::class, 'search'])->name('projects.search');
// Route::delete('/projects/bulk-delete', [ProjectController::class, 'bulkDelete'])->name('projects.bulkDelete');

// group of routes with a prefix method: 1
// Route::prefix('projects')->group(function () {
//    Route::controller(ProjectController::class)->group(function(){
//     Route::get('/fetch','fetchProjects')->name('projects.fetch');
//     Route::post('/export-projects', 'exportProjects')->name('projects.export');
//     Route::post('/import-projects', 'importProjects')->name('projects.import.projects');
//     Route::get('/export-pdf', 'exportProjectsPdf')->name('projects.export.pdf');
//     Route::get('/search', 'search')->name('projects.search');
//     Route::delete('/bulk-delete', 'bulkDelete')->name('projects.bulkDelete');
//    }); 
// });

// group of routes with a prefix method: 2
Route::prefix('projects')->controller(ProjectController::class)->group(function () {
    Route::get('/fetch', 'fetchProjects')->name('projects.fetch');
    Route::post('/export-projects', 'exportProjects')->name('projects.export');
    Route::post('/import-projects', 'importProjects')->name('projects.import.projects');
    Route::get('/export-pdf', 'exportProjectsPdf')->name('projects.export.pdf');
    Route::get('/search', 'search')->name('projects.search');
    Route::delete('/bulk-delete', 'bulkDelete')->name('projects.bulkDelete');
});


// Resource controller routes
Route::resource('projects', ProjectController::class);


