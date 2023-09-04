# Customer registry
This is a customer register app using FullCalendar javascript plugin with Laravel backend. The user can register customers in reception time's.

The application generates background events based on reception times.

## Requirements
- PHP v8.1
- Composer
- Npm

## Installation
- Create a database
- Copy .env.example to .env
- Run `composer deploy` command to install dependencies

## Usage
- Run `php -S 127.0.0.1:80 -t public` command to start the application with a basic server on localhost

## Tests
- Create a test database based on .env.testing
- Run `php artisan test` command for unit and integration tests 

## Author
* Gábor Farkas
## License
[![License: GPL v3](https://img.shields.io/badge/License-GPLv3-blue.svg)](https://www.gnu.org/licenses/gpl-3.0)
