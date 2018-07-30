<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

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

	public function scopeFilter($query, $filters) {
		if (array_key_exists('month', $filters) && $month = $filters['month']) {
			$query->whereMonth('created_at', Carbon::parse($month)->month);
		}

		if (array_key_exists('year', $filters) && $year = $filters['year']) {
			$query->whereYear('created_at', $year);
		}
	}
}
