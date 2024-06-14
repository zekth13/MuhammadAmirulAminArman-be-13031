<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\MovieController;
use App\Http\Controllers\Api\TheatreController;
use App\Http\Controllers\Api\RatingController;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
//Movie routes
Route::get('movies', [MovieController::class, 'index']); //Get movie all data
Route::post('movies', [MovieController::class, 'store']); //Post movie data
Route::get('movies/id', [MovieController::class, 'show']); //Get a movie data
Route::put('movies', [MovieController::class, 'update']); //Update movie data
Route::delete('movies/id', [MovieController::class, 'delete']); //Delete a movie data
Route::get('movies/genre', [MovieController::class, 'findgenre']); //Find genre
Route::get('movies/search_actor', [MovieController::class, 'searchactor']); //Find actor
Route::get('movies/new_movies', [MovieController::class, 'newmovies']); //Find actor


//Theatre routes
Route::get('theatre', [TheatreController::class, 'index']); //Get theatre all data
Route::post('theatre', [TheatreController::class, 'store']); //Post theatre data
Route::get('theatre/id', [TheatreController::class, 'show']); //Get a movie data
Route::put('theatre', [TheatreController::class, 'update']); //Update movie data
Route::delete('theatre/id', [TheatreController::class, 'delete']); //Delete a movie data
Route::get('theatre/timeslot', [TheatreController::class, 'gettimeslot']); //Get a timeslot

//Rating routes
Route::get('rating', [RatingController::class, 'index']); //Get rating all data
Route::post('rating/giverating', [RatingController::class, 'giverating']); //Post rating
Route::delete('rating/id', [RatingController::class, 'delete']); //Delete a rating data