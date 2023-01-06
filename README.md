# 🔑 Laravel Shield

> A [HTTP basic auth](https://en.m.wikipedia.org/wiki/Basic_access_authentication) middleware for Laravel.

[![Latest Version on Packagist](https://img.shields.io/packagist/v/jalallinux/laravel-shield.svg?style=flat-square)](https://packagist.org/packages/jalallinux/laravel-shield)
[![Tests](https://github.com/jalallinux/laravel-shield/actions/workflows/run-tests.yml/badge.svg?branch=main)](https://github.com/jalallinux/laravel-shield/actions/workflows/run-tests.yml)
[![Total Downloads](https://img.shields.io/packagist/dt/jalallinux/laravel-shield.svg?style=flat-square)](https://packagist.org/packages/jalallinux/laravel-shield)

```php
// Use on your routes.
Route::get('/', ['middleware' => 'shield'], function () {
    // Your protected page.
});

// Use it within your controller constructor.
$this->middleware('shield');

// Use specific user credentials.
$this->middleware('shield:jalallinux');
```


## Installation

Require this package, with [Composer](https://getcomposer.org/), in the root directory of your project.

```bash
composer require jalallinux/laravel-shield
```

Add the middleware to the `$routeMiddleware` array in your `Kernel.php` file.

```php
'shield' => \JalalLinuX\Shield\ShieldMiddleware::class,
```

## Configuration

Laravel Shield requires configuration. To get started, you'll need to publish all vendor assets:

```bash
$ php artisan vendor:publish --provider JalalLinuX\\Shield\\ShieldServiceProvider
```

This will create a `config/shield.php` file in your app that you can modify to set your configuration. Also, make sure you check for changes to the original config file in this package between releases.

#### HTTP Basic Auth Credentials

The user credentials which are used when logging in with [HTTP basic authentication](https://en.m.wikipedia.org/wiki/Basic_access_authentication).

## Usage

To protect your routes with the shield you can add it to the routes file.

```php
Route::get('/', ['middleware' => 'shield'], function () {
    // Your protected page.
});
```

You can also add the shield middleware to your controllers constructor.

```php
$this->middleware('shield');
```

The middleware accepts one optional parameter to specify which user credentials to compared with.

```php
$this->middleware('shield:jalallinux');
```

To add a new user, you probably want to use hashed credentials. Hashed credentials can be generated with the [`password_hash()`](https://secure.php.net/manual/en/function.password-hash.php) function in the terminal:

```sh
$ php -r "echo password_hash('my-secret-passphrase', PASSWORD_DEFAULT);"
```

Then copy and paste the hashed credentials to the `.env` environment file.

```bash
SHIELD_USER=your-hashed-user
SHIELD_PASSWORD=your-hashed-password
```
