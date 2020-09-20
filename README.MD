
# Light Message

Lightweight utility for sending fine-grained notifications in small batches.

## Requirements

* [PHP 7.3+](https://www.php.net/downloads.php)
* [Composer (PHP dependency manager)](https://getcomposer.org/download/)

## Installing dependencies
Let composer find and install latest versions of dependencies
```bash 
composer update
```

## Configuration
Rename the file `Settings` to `Settings.php` and change the parameters according to your Oauth consumer app. 

Checkout [MediaWiki  documentation ](https://www.mediawiki.org/wiki/OAuth/For_Developers) for more details on creating your Oauth credentials.

## Quickstart the app
```bash
php -S localhost:5000
```

## Unit testing
Do some testing by running the following command 
```bash
composer test
```