<?php

Route::get('/', function () {
	// $tasks = [
	// 	'Go to the store',
	// 	'Finish project',
	// 	'Clean the house'
	// ];

	$tasks = DB::table('tasks')->get();

	return view('task.index', compact('tasks'));
});

Route::get('/tasks/{task}', function ($task) {
	// returns a view in resources/views/tasks/show.blade.php
	return view('tasks.show', compact('task'));
});
