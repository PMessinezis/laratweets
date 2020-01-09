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

Route::middleware(['auth'])->group(function () {
    Route::post('logout', 'Auth\LoginController@logout')->name('logout');
    Route::get('/', 'HomeController@index')->name('home');
    Route::redirect('/home', '/');
    Route::get('/twitter/timeline', 'TwitterController@getTimeline');
});

Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');

Route::get('login/{provider}', 'Auth\LoginController@redirectToProvider');
Route::get('login/{provider}/callback', 'Auth\LoginController@handleProviderCallback');
