<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
	/* This is not a query scope and cannot be chained 
	   This will work: App\Task::incomplete()
	   But this will not: App\Task::incomplete()->where('id' '>' 2); */
    public static function incomplete() {
		return static::where('completed', 0)->get();
	}

	/* This is a query scope, and we can do this:
	   App\Task::incomplete()->get(); 
	   or this
	   App\Task::incomplete()->where('id' '>' 2)->get(); */
	public function scopeIncomplete($query, $optionalArg) {
		return $query->where('completed', 0);
	}
}
