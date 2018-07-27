<?php

Route::get('/', function () {
	$tasks = [
		'Go to the store',
		'Finish project',
		'Clean the house'
	];

	return view('welcome', compact('tasks'));
});
