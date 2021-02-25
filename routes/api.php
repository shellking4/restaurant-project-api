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

/*Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});*/
Route::get('foods', 'App\Http\Controllers\FoodController@getAllFoods');
Route::get('foods/{id}', 'App\Http\Controllers\FoodController@getFood');
Route::get('foods/store_food', 'App\Http\Controllers\FoodController@addFood');
Route::get('foods/delete_food/{id}', 'App\Http\Controllers\FoodController@deleteFood');
Route::put('foods/update/{id}', 'App\Http\Controllers\FoodController@updateFood');

