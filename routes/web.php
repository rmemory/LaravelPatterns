<?php

Auth::routes();

Route::get('/', 'PostsController@index')->name('home');
Route::group(['middleware' => 'auth'], function () {
	Route::get('/posts/create', 'PostsController@create');
	Route::get('/posts/{post}', 'PostsController@show');
	Route::post('/posts/{post}/comments', 'CommentsController@store');
	Route::post('/posts', 'PostsController@store');
});

/*
	GET /posts
	GET /posts/create
	POST /posts
	GET /posts/{id}/edit
	GET /posts/{id}
	PATCH /posts/{id}
	DELETE /posts/{id}
 */


