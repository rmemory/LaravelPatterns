A project containing a few different Laravel concepts ...

Here are some notes:

1) To create a project, do the following. This assumes the necessary composer, php, Larvel, and apache libraries have been installed. Quite a few details are ommitted here. Google is your friend. Note that I am not using Laravel's valet or homestead. I use Apache to serve the page locally. This is just a general outline of the major steps involved. 

For what its worth, at the moment, I am using an Ubuntu 18.04 host, php 7.1, composer 1.6.5, Apache 2.4.29, and Laravel 5.6.29.

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
php dump-autoload
```

The usual database migration commands:

```
$ php artisan make:migrate create_tasks_table --create=tasks
$ php artisan migrate 
$ php artisan migrate:refresh
```

A help command
```
$ php artisan make help
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

