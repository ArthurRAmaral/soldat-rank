<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400"></a></p>

<p align="center">
<a href="https://travis-ci.org/laravel/framework"><img src="https://travis-ci.org/laravel/framework.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>


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


