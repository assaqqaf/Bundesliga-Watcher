# Bundesliga Watcher

## System Requirements

* PHP >= 7.0.0 with
    * OpenSSL PHP Extension
    * PDO PHP Extension
    * Mbstring PHP Extension
    * Tokenizer PHP Extension
* [Composer](https://getcomposer.org) installed to load the dependencies.

## Install

1. Install dependencies, run:
`composer install`
2. Renamed the `.env.example` file to `.env`
3. Simply run `php artisan serve`

## Technology used
* Laravel 5.5 was chosen as it's among affordable and easy framework to build a website.
* Guzzlehttp 6 used to provide a clean wrapper connect with API

## Workflow
* `Openligadb` class: suppose to developed as an external package (whether public or private) for openligadb API  wrapper.
Also, we can define an interface to support multiple driver (sources) to receive the data.

* `League` class where the business logic is stored, to receive and process data.
* The remaining code is located in Controller.
