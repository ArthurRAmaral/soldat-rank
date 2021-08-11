## About Soldat Ranking System
This website aims to provide a competitive gameplay to Soldat players.

Frameworks used:
 - [Laravel 8 + blade template](https://laravel.com/docs/8.x).
 - [Bootstrap 5](https://getbootstrap.com/docs/5.0/getting-started/introduction/).
 - [Adminlte v3](https://github.com/jeroennoten/Laravel-AdminLTE/wiki).


## How to install and run
In a terminal run de following commands:
 - git clone "https://github.com/tomatte/soldat-rank"
 - npm install
 - composer install

Rename the .env.example file to .env and make the propper configurations and create a database to run the migrations, then run the following commands:

 - php artisan key:generate
 - php artisan migrate

And finnally to run the application just enter this command:

 - php artisan serve

## Recommendations
The Adminlte framework provides a beautiful, responsive and robust template with a lot of components to be added as needed. Go ahead and read the docummentation [here](https://github.com/jeroennoten/Laravel-AdminLTE/wiki) to learn how to take the best from it.