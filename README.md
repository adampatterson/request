# Request PHP

![PHP Composer](https://github.com/adampatterson/request/workflows/run-tests/badge.svg?branch=main)
[![Packagist Version](https://img.shields.io/packagist/v/adampatterson/request)](https://packagist.org/packages/adampatterson/request)
[![Packagist Downloads](https://img.shields.io/packagist/dt/adampatterson/request)](https://packagist.org/packages/adampatterson/request/stats)

> [!NOTE]
> This script is still under development.

## View on [Packagist](https://packagist.org/packages/adampatterson/request)

```shell
composer require adampatterson/request
```

## Usage

```php
use Request\Request;

// Get a value from the request (checks $_GET first, then $_POST)
$name = Request::get('name');

// Get a value with a default fallback
$page = Request::get('page', 1);

// Get all GET parameters
$query = Request::all('GET');

// Get all POST parameters
$post = Request::all('POST');

// Check if a query parameter exists
if (Request::has('search')) {
    // ...
}

// Get request information
$method    = Request::method();    // GET, POST, etc.
$ip        = Request::ip();        // Client IP
$userAgent = Request::userAgent(); // Browser User Agent
$uri       = Request::uri();       // Full request URI
$root      = Request::root();      // Root URL
```

## Method Proxying

The `Request` class proxies unknown method calls to the underlying Symfony HTTP Foundation `Request` instance. This allows you to use any method provided by Symfony's Request object.

```php
use Request\Request;

// getPathInfo() is a Symfony Request method
$path = Request::getPathInfo();

// You can also access the underlying Symfony Request instance directly
$symfonyRequest = Request::instance();
```

## Tests

```shell
composer install
composer test
```

## Local Dev

Without needing to modify the composer.json file. Run from the theme root, this will symlink the package into the theme's vendor directory.

```shell
ln -s ~/Sites/packages/request/ ./vendor/adampatterson/request
```

Otherwise, you can add the local package to your `composer.json` file.

```json
{
  "repositories": [
    {
      "type": "path",
      "url": "/Sites/packages/request"
    }
  ]
}
```
