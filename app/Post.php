<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use App\Comment;
use App\User;

class Post extends Model
{
	protected $fillable = ['title', 'body', 'user_id'];

	public function comments() {
		return $this->hasMany(Comment::class);
	}

	public function addComment($body) {
		$user_id = auth()->user()->id;
		dd($user_id);
		$this->comments()->create(compact('body', 'user_id'));
	}

	public function user() {
		return $this->belongsTo(User::class);
	}
}
