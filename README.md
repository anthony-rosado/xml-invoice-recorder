# XML Invoice Recorder

An API to manage information of XML invoices

## Features

The following options are available:

- User authentication
- Upload invoice XML file
- Invoice summary notification
- Invoice list with pagination
- Invoice full detail
- Delete invoices
- Get total accumulated amount of items per currency
- Get total accumulated amount of invoices per currency

A Postman collection is available to test the API:

[![Run in Postman](https://run.pstmn.io/button.svg)](https://app.getpostman.com/run-collection/7130305-e2e89f74-ad20-4863-afa8-b6417fee1e63?action=collection%2Ffork&source=rip_markdown&collection-url=entityId%3D7130305-e2e89f74-ad20-4863-afa8-b6417fee1e63%26entityType%3Dcollection%26workspaceId%3D84668433-de41-4537-a343-be9c7c16fddc)

## Installation

### Requirements

This project use the [Sail](https://laravel.com/docs/10.x/sail) package, so you will need:

- Docker
- Docker Compose

### Set up the environment

First you will have to install the Composer dependencies:

```shell
docker run --rm \
    --pull=always \
    -v "$(pwd)":/opt \
    -w /opt \
    laravelsail/php82-composer:latest \
    bash -c "composer install"
```

Then you will have to start the containers:

```shell
./vendor/bin/sail up -d
```

And enter the `laravel.test` container with:

```shell
docker exec -it xml-invoice-recorder-laravel.test-1 bash
```

### Prepare the database

Once inside the container, run the migrations and seed the tables:

```shell
php artisan migrate --seed
```

Since the [Passport](https://laravel.com/docs/10.x/passport) package is used for authentication, you will have to install it:

```shell
php artisan passport:install
```

Great, you are ready to use the features of this project.

## Tests

Run the unit and feature tests (inside the `laravel.test` container) with:

```shell
php artisan test
```
