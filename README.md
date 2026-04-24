# Request PHP

![PHP Composer](https://github.com/adampatterson/Request/workflows/PHP%20Composer/badge.svg?branch=main)

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

## Tests

```shell
composer install
composer test
```

## Local Dev

Without needing to modify the composer.json file. Run from the theme root, this will symlink the package into the theme's vendor directory.

```shell
ln -s ~/Sites/packages/Request/ ./vendor/adampatterson/request
```

Otherwise, you can add the local package to your `composer.json` file.

```shell
  "repositories": [
    {
      "type": "path",
      "url": "/Sites/packages/request"
    }
     ],
```
