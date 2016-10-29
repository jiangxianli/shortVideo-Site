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

//Route::post('/normal-list','ApiController@getNormalList');
//Route::get('/detail/{id}','ShortVideoController@getDetail');
//
//Route::get('/watch-history','UserController@getWatchHistoryPage');
//Route::post('/watch-list','UserController@getWatchList');
//Route::get('/login','UserController@getLogin');
//Route::get('/logout','UserController@getLogout');
//Route::get('/login-page','UserController@getLoginPage');
//
//
//Route::get('/tags','TagController@getTagPage');
//Route::post('/tag-list','TagController@getTagList');
//
//
//Route::get('/tag/{id}','TagController@getTagDetail');
//
//Route::post('/tag/{id}/items','TagController@getTagVideoList');
//
//Route::get('/click-count/{id}','ShortVideoController@postClickCount');


Route::group(['prefix' => 'api'], function () {
    Route::get('login', 'ApiController@getLogin');
    Route::get('logout', 'ApiController@getLogout');
});

Route::group(['prefix' => 'user'], function () {
    Route::get('login-page', 'UserController@getLoginPage');
    Route::get('watch-history', 'UserController@getWatchHistoryPage');
    Route::post('watch-list', 'UserController@postWatchList');
});

Route::group(['prefix' => 'short-video'], function () {
    Route::post('normal-list', 'ShortVideoController@postNormalList');
    Route::get('{id}/detail', 'ShortVideoController@getDetail');
    Route::get('{id}/click-count','ShortVideoController@postClickCount');
});

Route::group(['prefix' => 'tags'], function () {
    Route::get('/','TagController@getTagPage');
    Route::post('{id}/items','TagController@postTagVideoList');
    Route::get('{id}','TagController@getTagDetail');
    Route::post('list','TagController@postTagList');
});
