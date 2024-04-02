<?php

use Illuminate\Http\Request;
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

Route::get('albums/search', [\App\Http\Controllers\Api\AlbumController::class, 'search']);
Route::get('albums', [\App\Http\Controllers\Api\AlbumController::class, 'index']);
Route::get('albums/{id}', [\App\Http\Controllers\Api\AlbumController::class, 'show']);
Route::post('albums/{id}', [\App\Http\Controllers\Api\AlbumController::class, 'update']);
Route::post('albums', [\App\Http\Controllers\Api\AlbumController::class, 'store']);
Route::delete('albums/{id}', [\App\Http\Controllers\Api\AlbumController::class, 'destroy']);

Route::post('images', [\App\Http\Controllers\Api\ImageController::class, 'store']);
Route::delete('images/{id}', [\App\Http\Controllers\Api\ImageController::class, 'destroy']);
Route::delete('images', [\App\Http\Controllers\Api\ImageController::class, 'destroyAll']);


