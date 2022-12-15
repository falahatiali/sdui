<p align="center"><a href="https://laravel.com" target="_blank">
<h1>
    SDUI
</h1>

<p align="center"></p>

## How to run project

This project is based on docker and runs 3 containers for running.
first you should clone the project
```angular2html
git clone git@github.com:falahatiali/sdui.git
```

then create a .env file. you can do this by copying from .env.example
```angular2html
cp .env.example .env
```

the default database is sqlite. if you want to change you just add a MySQL container to docker-compose
and then change the DB variables in .env file.


in next step you should just run following commands:
```angular2html

docker-compose up -d 
docker exec -it sdui composer install
docker exec -it sdui php artisan key:generate
docker exec -it sdui php artisan migrate
```

for running tests run following command:

```angular2html
docker exec -ti sdui ./vendor/bin/phpunit
```

if you want to see that cronjob works or not first you should run database seed
```angular2html
php artisan db:seed
```

then you can edit app/Console/Kernel.php file and run schedule commnand every minute

you should edit run function and uncomment line 19 
```angular2html
$schedule->command('news:delete_all')->everyMinute();
```
and commect line 20:
```angular2html
$schedule->command('news:delete_all')->dailyAt('02:00');
```

then look at laravel.log file. after 1 minute you can see there is a log about removing data.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
