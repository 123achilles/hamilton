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


Route::post('login', 'Api\AuthController@login')->name('login');
Route::post('register', 'Api\AuthController@register')->name('register');

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});


Route::group([
    'middleware' => ['admin'],
    'namespace' => "Api\Admin",
    'prefix' => 'admin'
], function () {

    Route::get('exams', 'ExamController@index');
    Route::post('exam/store', 'ExamController@store');
    Route::put('exam/update/{id}', 'ExamController@update');
    Route::get('exam/{id}', 'ExamController@show');
    Route::delete('exam/delete/{id}', 'ExamController@delete');

    Route::post('section/store', 'SectionController@store');
    Route::put('section/update/{id}', 'SectionController@update');
    Route::get('section/{id}', 'SectionController@show');
    Route::delete('section/delete/{id}', 'SectionController@delete');
});


