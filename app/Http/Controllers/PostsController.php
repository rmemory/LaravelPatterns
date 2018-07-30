<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Post;

class PostsController extends Controller
{
	public function index() {
		$posts = Post::orderBy('created_at', 'desc')
		->filter(request(['month', 'year']))
		->get();

		$archives = Post::selectRaw('year(created_at) as year, monthname(created_at) as month, count(*) as published')
			->groupBy('year', 'month')
			->orderByRaw('min(created_at) desc') 
			->get();
		return view('posts.index', compact('posts', 'archives'));
	}

	public function create() {
		return view('posts.create');
	}

	public function show(Post $post) {
		return view('posts.show', compact('post'));
	}

	public function store(Request $request) {
		/* If the validation fails, it just redirects 
		   back to the previous page and it contains a
		   populate errors session variable */
		$this->validate(request(), [
			'title' => 'required|min:2',
			'body' => 'required'
		]);

		auth()->user()->publish(new Post(request(['title', 'body'])));

		// Post::create([
		// 	'title' => request('title'),
		// 	'body' => request('body'),
		// 	'user_id' => auth()->user()->id,
		// ]);

		return redirect('/');
	}
}
