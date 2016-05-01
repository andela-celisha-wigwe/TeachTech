<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::auth();

Route::get('/home', 'HomeController@index');

Route::get('auth/{link}', 'Auth\AuthController@redirectToProvider');
Route::get('auth/{link}/callback', 'Auth\AuthController@handleProviderCallback');
Route::post('twitter/login', 'Auth\AuthController@useTwitterEmail');
Route::post('video/add', 'VideosController@createVideo');
Route::get('videos', 'VideosController@index');
Route::get('video/{id}/edit', 'VideosController@edit');
Route::get('video/{id}/delete', 'VideosController@delete');
Route::delete('video/{id}', 'VideosController@destroy');
Route::get('video/{id}', 'VideosController@show');
Route::post('video/{id}/update', 'VideosController@update');
Route::post('user/update', 'UsersController@updateUser');
Route::get('categories', 'CategoriesController@index');
Route::post('comment', 'CommentsController@create');
Route::delete('comment/delete', 'CommentsController@destroy');
Route::patch('comment/{id}', 'CommentsController@update');
Route::post('user/upload/avatar', 'UsersController@changeAvatar');

Route::post('video/search', 'VideosController@search');
