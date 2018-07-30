<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Comment;
use App\Post;

class CommentsController extends Controller
{
	public function store(Post $post) {

		$this->validate(request(), [
			'body' => 'required|min:2'
		]);
		$post_id = $post->id;
		$body = request('body');
		auth()->user()->publishComment(
			new Comment(
				compact('body', 'post_id')
			)
		);
		// Comment::create([
		// 	'body' => request('body'),
		// 	'post_id' => $post->id
		// ]);

		// $post->addComment(request('body'));

		return back();
	}
}
