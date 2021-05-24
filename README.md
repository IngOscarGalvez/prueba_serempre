# Prueba Serempre

## Installation

Please check the official laravel installation guide for server requirements before you start. [Official Documentation](https://laravel.com/docs/7.x/installation#installation)


Clone the repository

    git clone https://github.com/IngOscarGalvez/prueba_serempre.git

Switch to the repo folder

    cd prueba_serempre

Install all the dependencies using composer

    composer install
    
Install all the dependencies using npm & deploy (Node)

    npm install
    npm run prod

Copy the example env file and make the required configuration changes in the .env file

    cp .env.example .env

Generate a new application key

    php artisan key:generate


Run the database migrations & seeder (**Set the database connection in .env before migrating**)

    php artisan command:EjecutarBD

Start the local development server

    php artisan serve

You can now access the server at http://localhost:8000

**TL;DR command list**

    git clone https://github.com/IngOscarGalvez/prueba_serempre.git
    cd prueba_serempre
    composer install
    npm install
    npm run prod
    cp .env.example .env
    php artisan key:generate
    
**Make sure you set the correct database connection information before running the migrations** [Environment variables](#environment-variables)

    php artisan serve

----------

## Folders

- `app` - Contains all the Eloquent models
- `app/Http/Controllers/Api` - Contains all the controllers
- `app/Http/Controllers/Api` - Contains all the api controllers
- `app/Http/Requests` - Contains all the form requests
- `app/Http/Requests/Api` - Contains all the api form requests
- `config` - Contains all the application configuration files
- `database/factories` - Contains the model factory for all the models
- `database/migrations` - Contains all the database migrations
- `database/seeds` - Contains the database seeder
- `routes` - Contains all the api routes defined in web.php file

## Environment variables

- `.env` - Environment variables can be set in this file

***Note*** : You can quickly set the database information and other variables in this file and have the application fully working.

----------

# Testing

Run the laravel development server

    php artisan serve

The api can now be accessed at

    http://localhost:8000
