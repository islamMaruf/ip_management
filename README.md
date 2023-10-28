# IP Management 


# Getting started

## Installation

Clone the repository

    git clone https://github.com/islamMaruf/ip_management.git

Switch to the repo folder

    cd ip_management

Install all the dependencies using composer

    composer install

Copy the example env file and make the required configuration changes in the .env file

    cp .env.example .env

Generate a new application key

    php artisan key:generate

Generate a new JWT authentication secret key

    php artisan jwt:generate

Run the database migrations (**Set the database connection in .env before migrating**)

    php artisan migrate

Start the local development server

    php artisan serve

You can now access the server at http://localhost:8000

**TL;DR command list**

    git clone https://github.com/islamMaruf/ip_management.git
    cd ip_management
    composer install
    cp .env.example .env
    php artisan key:generate
    php artisan jwt:generate 
    
**Make sure you set the correct database connection information before running the migrations**
    php artisan migrate
    php artisan serve

## Database seeding

**Populate the database with seed data. This can help you to quickly start testing the api or couple a frontend and start using it with ready content.**

Run the database seeder and you're done

    php artisan db:seed

***Note*** : It's recommended to have a clean database before seeding. You can refresh your migrations at any point to clean the database by running the following command

    php artisan migrate:refresh

## Run the test cases

Run the test cases after setup the application

    php artisan test

***Note*** : It's recommended that phpunit.xml file is properly setup for running the test case and sqlite php extension is installed on the system

## Folders

- `app/Http/Models` - Contains all the Eloquent models
- `app/Http/Controllers` - Contains all the api controllers
- `app/Http/Middleware` - Contains the JWT auth middleware
- `app/Http/Requests` - Contains all the form requests
- `app/Interfaces` - Contains the interfaces that is implemented by Repositories
- `app/Repositories` - Contains the repositories
- `app/Observers` - Contains the observers
- `app/Facade` - Contains the custom Facade class
- `app/Services` - Contains the service classes
- `config` - Contains all the application configuration files
- `database/factories` - Contains the model factory for all the models
- `database/migrations` - Contains all the database migrations
- `database/seeds` - Contains the database seeder
- `routes` - Contains all the api routes defined in api.php file
- `tests` - Contains all the application tests

## Environment variables

- `.env` - Environment variables can be set in this file

***Note*** : You can quickly set the database information and other variables in this file and have the application fully working.

----------

# Testing API

Run the laravel development server

    php artisan serve

The api can now be accessed at

    http://localhost:8000/api

Request headers

| **Required** 	| **Key**       | **Value**            	|
|----------	|------------------	|------------------	|
| Yes      	| Content-Type     	| application/json 	|
| Optional 	| Authorization    	| Bearer {TOKEN}    |

----------
