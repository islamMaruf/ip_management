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

    php artisan jwt:secret

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
    php artisan jwt:secret 
    
**Make sure you set the correct database connection information before running the migrations**
    php artisan migrate
    php artisan serve

## Database seeding

**Populate the database with seed data. This can help you to quickly start testing the api or couple a frontend and start using it with ready content.**

Run the database seeder and you're done

    php artisan db:seed

***Note*** : It's recommended to have a clean database before seeding. You can refresh your migrations at any point to clean the database by running the following command

    php artisan migrate:refresh

## Running Tests

To run tests, run the following command
    
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
## API Documentation

## Authorization

All the requests rather that login need Bearer token to authenticate the api

To authenticate an API request, you should provide your Token in the `Authorization` header.

#### Getting the authenticated user’s details
Returns details of the authenticate user of the application.

```
GET /auth/user-profile
```

Example request:

```
GET /api/auth/user-profile HTTP/1.1
Host: 127.0.0.1:8000
Accept: application/json
Authorization: Bearer {TOKEN}
```

The response is a User object within a data.

Example response:

```
HTTP/1.1 200 OK
Content-Type: application/json; charset=utf-8
{
    "success": true,
    "code": 200,
    "message": "Fetch logged in user data",
    "data": {
        "id": 1,
        "name": "Maruf islam",
        "email": "maruf@gmail.com",
        "email_verified_at": "2023-10-28T07:40:15.000000Z",
        "created_at": "2023-10-28T07:40:15.000000Z",
        "updated_at": "2023-10-28T07:40:15.000000Z"
    }
}
```
Where a User object is:

| Field      | Type   | Description                                     |
| -----------|--------|-------------------------------------------------|
| id         | string | A unique identifier for the user.               |
| name       | string | The user’s name .                               |
| email      | string | The URL to the user’s email.                    |
| email_verified_at   | string |  Timestamp when email verified         |
| created_at | string |  Timestamp when user created                    |
| updated_at | string |  Timestamp when user updated                    |

Possible errors:

| Error code           | Description                                     |
| ---------------------|-------------------------------------------------|
| 401                  | Unauthorized                                    |

## Responses

Many API endpoints return the JSON representation of the resources created or edited. However, if an invalid request is submitted, or some other error occurs,JSON responses in the following format:

```javascript
{
  "success" : bool,
  "code"    : number,
  "message" : string,
  "data"    : string
}
```

The `success` attribute describes if the transaction was successful or not.

The `code` attribute describes a code related to the transaction.

The `message` attribute contains a message commonly used to indicate errors or, in the case of deleting a resource, success that the resource was properly deleted.

The `data` attribute contains any other metadata associated with the response. This will be an escaped string containing JSON data.

## Status Codes

The following status codes in its API:

| Status Code | Description |
| :--- | :--- |
| 200 | `OK` |
| 201 | `CREATED` |
| 204 | `NO CONTENT` |
| 400 | `BAD REQUEST` |
| 401 | `UNAUTHORIZED` |
| 403 | `FORBIDDEN` |
| 404 | `NOT FOUND` |
| 422 | `UNPROCESSABLE ENTITY` |
| 500 | `INTERNAL SERVER ERROR` |

--------------------------------------------
***Note*** : Full API documentation is in process will be updated soon.
