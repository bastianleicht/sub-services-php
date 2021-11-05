Sub-Services PHP API Client
=======================
This **PHP 7.2+** library allows you to communicate with the Sub.Services API.

[![Latest Stable Version](http://poser.pugx.org/bastianleicht/sub-services-php/v)](https://packagist.org/packages/bastianleicht/sub-services-php)
[![Total Downloads](http://poser.pugx.org/bastianleicht/sub-services-php/downloads)](https://packagist.org/packages/bastianleicht/sub-services-php)
[![Latest Unstable Version](http://poser.pugx.org/bastianleicht/sub-services-php/v/unstable)](https://packagist.org/packages/bastianleicht/sub-services-php)
[![License](http://poser.pugx.org/bastianleicht/sub-services-php/license)](https://packagist.org/packages/bastianleicht/sub-services-php)

> You can find the full API documentation [here](https://sub.services/go/api-docs)!

## Getting Started

Recommended installation is using **Composer**!

In the root of your project execute the following:
```sh
$ composer require bastianleicht/sub-services-php
```

Or add this to your `composer.json` file:
```json
{
    "require": {
        "bastianleicht/sub-services-php": "^1.0"
    }
}
```

Then perform the installation:
```sh
$ composer install --no-dev
```

### Examples

Creating the SubServices main object:

```php
<?php
// Require the autoloader
require_once 'vendor/autoload.php';

// Use the library namespace
use SubServices\SubServices;

// Then simply pass your API-Token when creating the API client object.
$client = new SubServices('API-Token');

// Then you are able to perform a request
var_dump($client->instance()->show(9999));
?>
```

If you want more info on how to use this PHP-API you should check out the [Wiki](https://github.com/bastianleicht/sub-services-php/wiki).
