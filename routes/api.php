<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PeopleController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('/people', [PeopleController::class, 'index']);
Route::post('/people/{id}/like', [PeopleController::class, 'like']);
Route::post('/people/{id}/dislike', [PeopleController::class, 'dislike']);
Route::get('/people/liked', [PeopleController::class, 'likedPeople']);
