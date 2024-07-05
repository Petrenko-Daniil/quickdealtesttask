<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
Route::group([], function (){
    Route::resource('tasks', \App\Http\Controllers\Api\TaskController::class);
    Route::post('/tasks/getBy/{field}', [\App\Http\Controllers\Api\TaskController::class, 'getBy'])->name('tasks.getBy');
});

