A project containing a few different Laravel concepts ...

Here are some notes:

1) To create a project, do the following. This assumes the necessary composer, php, Larvel, and apache libraries have been installed. Quite a few details are ommitted here. Google is your friend. Note that I am not using Laravel's valet or homestead. I use Apache to serve the page locally. This is just a general outline of the major steps involved. This readme does assume you already have some familiarity with Laravel beforehand. 

For what its worth, at the moment, I am using an Ubuntu 18.04 host, php 7.1, composer 1.6.5, Apache 2.4.29, and Laravel 5.6.29.

And I have installed the chrome JSON Formatter extension.

```
<install composer, php 7.1, with a bunch of php libs>
$ sudo apt-get install apache2
$ mkdir ~/www
$ sudo ln -s /var/www ~/www
$ cd ~/www
$ composer create-project --prefer-dist laravel/laravel myproject
$ cd myproject
$ touch storage/logs/laravel.log
$ chmod -R 777 storage/

<edit the .env file to point at the new database, and create it in MySql>
<create a new conf file in /etc/apache2/sites-available/>
<edit /etc/hosts file>

<allow Laravel to do the routing>
$ sudo a2enmod rewrite # See: https://www.digitalocean.com/community/tutorials/how-to-set-up-mod_rewrite

$ sudo a2ensite myproject.conf
$ sudo systemctl reload apache2

<at this point, the basic welcome view should be visible in the browser>
```

2) A few useful artisan commands.

This command returns a list of all the artisan commands available

```
$ php artisan
```

This command returns a list of current routes:

```
$ php artisan route:list > route.txt
```

If laravel gets confused

```
$ composer dump-autoload
```

The usual database migration commands:

```
$ php artisan make:migration create_tasks_table --create=tasks
$ php artisan migrate 
$ php artisan migrate:refresh
```

A help command
```
$ php artisan make help
```

Create a model with a migration

```
$ php artisan make:model Task -
```

Create a model with a migration and a controller

```
$ php artisan make:model Task -m -c
```

Create a model with a migration and a controller, where the controller is resourcful

```
$ php artisan make:model Task -m -c -r
```

3) Data can be passed to a view from a route, or a controller. It is passed using an array, which can be constructed using the php compact API.

```
Route::get('/', function () {
	$tasks = [
		'Go to the store',
		'Finish project',
		'Clean the house'
	];

	return view('welcome', compact('tasks'));
});
```

Or it can be passed using a with function call ...

```
return view('welcome')->with('tasks', $tasks);
```

And here is a simplistic way to view it in a blade:

```
<body>
	<ul>
		@foreach ($tasks as $task)
			<li>{{ $task }}</li>
		@endforeach
	</ul>
</body>
```

4) Here is an example of a migration with a foreign key

```
        Schema::create('tasks', function (Blueprint $table) {
			$table->increments('id');
			$table->integer('user_id');
			$table->text('body');
			$table->boolean('completed')->default(false);
			$table->timestamps();
			
			$table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
```

The above was created with this command:

```
$ php artisan make:migration create_tasks_table --create=tasks
```

And if we assume there is actual data in the database (I am skipping that part), then the route
or controller could get the full list of tasks using this query. This is Laravel's query builder.

```
	$tasks = DB::table('tasks')->get();

	return view('welcome', compact('tasks'));
```

But since in this case the value returned from the query is a collection of objects, and not just strings, that means I need to adjust the blade code slightly like this:

```
<body>
	<ul>
		@foreach ($tasks as $task)
			<li>{{ $task->body }}</li>
		@endforeach
	</ul>
</body>
```
5) Here is an example of route-model injection, with no need to use the query builder because Laravel found the correct task for me based on the URL

```
Route::get('/tasks/{task}', function (Task $task) {

	// returns a view in resources/views/tasks/show.blade.php
	return view('tasks.show', compact('task'));
});
```

Which is more or less the equivalent of this:

```
Route::get('/tasks/{id}', function ($id) {
	$task = DB::table('tasks')->find($id);
	// or this which uses Eloquent
	$task = App\Task::find($id);
	return view('tasks.show', compact('task'));
});
```

6) Tinker is a way to expirment with model objects

```
$ php artisan tinker
>>> App\User::all()
=> Illuminate\Database\Eloquent\Collection {#2872
     all: [],
   }

>>> App\User::where('id', '>=', 2)->get();
=> Illuminate\Database\Eloquent\Collection {#2861
     all: [],
   }

>>> App\User::pluck('email');
=> Illuminate\Support\Collection {#2872
     all: [],
   }

>>> App\User::pluck('email')->first();
=> null

>>> $task = new App\Task;
>>> $task->body = 'Go to the store';
>>> $task->save();

>>> App\Task::wehre('completed', 1)->get();

```

7) Using Eloquent, we can replace query builder calls with queries using the database like this:

```
$tasks = App\Task::all();
$task = App\Task::find($id);
//etc
```

And we could add a "query scope to the Task model class:

```
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
```

8) Controllers

Controllers are used to provide an intermediary between Models and Views. Based on the request (from the route), it will compile the necessary information from the model, and pass it to the view. Stated differently, the controller fetches whatever data is necessary for the view.

```
Route::get('/tasks', 'TasksController&index');
```

By default, they are name spaced to be located in App\Http\Controllers, though you can apply a group to them and middleware to them. Like this:

```
Route::group(['namespace' => '\View'], function () {
	/* These are all the auth protected web routes */
	Route::group(['middleware' => 'auth'], function () {
		Route::get('/tasks', 'TasksController&index');
```

See the app/Http/Kernel.php file to see what "auth" applies. There are other kinds of middleware.

Here is an example of the TasksController index and show function

```
class TasksController extends Controller
{
	public function index() {
		$tasks = Task::all();
		 return view('tasks.index', compact('tasks'));
	}

	public function show($id) {
		$task = Task::find($id);
		return view('tasks.show', compact('task'));
	}
}
```

Here is a way to create model, controller, and migration in a single command:

```
$ php artisan make:model Post -mc
Model created successfully.
Created Migration: 2018_07_28_024359_create_posts_table
Controller created successfully.

```

9) Route model binding

```
Route::get('/tasks/{task}', 'TasksController&show');
```

```
	public function show(Task $task) {
		//$task = Task::find($id);
		return view('tasks.show', compact('task'));
	}
```

10) Blade files

A top level layout blade might look like this:

```
<!DOCTYPE html>
<html>
<head>
	<title>My Application</title>
</head>
<body>
	@yield('content')
</body>
	@yield('footer')
</html>
```

And a client page might use this:

```
@extends('layout')

@section('content')
<div>blah blah</div>
@endsection

@section('footer')
<script src="myscript.js"></script>
@endsection
```


And example of a pivot table (relationships between multiple tables)
