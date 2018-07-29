<?php

Route::get('/', 'PostsController@index');
Route::get('/posts/create', 'PostsController@create');
Route::get('/posts/{post}', 'PostsController@show');
Route::post('/posts/{post}/comments', 'CommentsController@store');

Route::post('/posts', 'PostsController@store');

/*
	GET /posts
	GET /posts/create
	POST /posts
	GET /posts/{id}/edit
	GET /posts/{id}
	PATCH /posts/{id}
	DELETE /posts/{id}
 */
