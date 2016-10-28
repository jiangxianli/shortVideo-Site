<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/

Route::get('/', function () {
    return view('short-video.index');
});

Route::post('/normal-list','ApiController@getNormalList');
Route::get('/detail/{id}','ShortVideoController@getDetail');

Route::get('/watch-history','UserController@getWatchHistoryPage');
Route::post('/watch-list','UserController@getWatchList');
Route::get('/login','UserController@getLogin');
Route::get('/logout','UserController@getLogout');
Route::get('/login-page','UserController@getLoginPage');


Route::get('/tags','TagController@getTagPage');
Route::post('/tag-list','TagController@getTagList');


Route::get('/tag/{id}','TagController@getTagDetail');

Route::post('/tag/{id}/items','TagController@getTagVideoList');

Route::get('/click-count/{id}','ShortVideoController@postClickCount');
