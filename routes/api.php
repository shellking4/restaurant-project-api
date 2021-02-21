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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
Route::post('store_student', 'App\Http\Controllers\StudentController@addStudent');
Route::get('students', 'App\Http\Controllers\StudentController@allStudents');
Route::get('student/details', 'App\Http\Controllers\StudentController@getStudent');
Route::get('student/auth', 'App\Http\Controllers\StudentController@getStudentWithSpecifiedEmailAndPassword');
Route::get('allOffers', 'App\Http\Controllers\OfferController@allOffers');
Route::get('store_offer', 'App\Http\Controllers\OfferController@addOffer');
Route::get('news', 'App\Http\Controllers\NewsController@getAllNews');
