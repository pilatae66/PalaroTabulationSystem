<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return redirect()->route('judge.login');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::group(['prefix' => 'admins'], function () {

    Route::resource('/judge', 'JudgeController');

    Route::resource('/event', 'EventController');

    Route::get('event/{id}/criteria', 'CriteriaController@create')->name('criteria.create');

    Route::post('event/{id}/criteria', 'CriteriaController@store')->name('criteria.store');

    Route::get('event/{id}/criteria/{criteria}/edit', 'CriteriaController@edit')->name('criteria.edit');

    Route::patch('event/{id}/criteria/{criteria}', 'CriteriaController@update')->name('criteria.update');

    Route::delete('event/{id}/criteria/{criteria}', 'CriteriaController@destroy')->name('criteria.destroy');

    Route::resource('/contestant', 'ContestantController');
});
