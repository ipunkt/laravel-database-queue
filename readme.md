# Laravel 4 Database Queue Driver

## Push a function/closure to the Database queue.
This is a real queue driver, like beanstalkd or redis one.
You need a daemon like supervisor or similar to listen to your queue.

**ATTENTION**: We now support the right table structure for Laravel 5.2 and Laravel 5.3.

### Install
Add the package to the require section of your composer.json and run `composer update`

    "davelip/laravel-database-queue": "dev-master"

And add our repository source

	"repositories": [
	      {
	        "type": "vcs",
	        "url": "https://github.com/ipunkt/laravel-database-queue"
	      }
	    ]

Add the Service Provider to the providers array in config/app.php

    'Davelip\Queue\DatabaseServiceProvider',
    
I suggest to publish migrations, so they are copied to your regular migrations

    $ php artisan migrate:publish davelip/laravel-database-queue

And then run migrate 

    $ php artisan migrate 

You should now be able to use the database driver in config/queue.php

    'default' => 'database',
    
    'connections' => array(
        ...
        'database' => array(
            'driver' => 'database',
            'queue' => 'queue-name', // optional, can be null or any string
        ),
        ...
    }

It work in the same as beanstalkd or redis queue listener.

Listen for new job:

    $ php artisan queue:listen


### Laravel Queue System
For more info see http://laravel.com/docs/queues

#### Thanks
Loosely based on https://github.com/barryvdh/laravel-async-queue
