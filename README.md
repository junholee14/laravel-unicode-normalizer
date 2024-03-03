# Laravel Unicode Normalizer Package

## Introduction
The Laravel Unicode Normalizer package provides a simple and efficient way to normalize Unicode characters in your Laravel application. This package includes middleware for easy normalization of incoming requests and a validation rule to ensure that data is normalized before processing.

## Requirements
- PHP >= 8.1
- Laravel >= 10
- `intl` PHP extension

## Installation
To install the package, run the following command in your Laravel project:
```bash
composer require junholee14/laravel-unicode-normalizer
```
After installation, you can publish the package configuration using:

```bash
php artisan vendor:publish --provider="Junholee14\LaravelUnicodeNormalizer\UnicodeNormalizationProvider"
```
## Usage
### Middleware
The `NormalizeUnicode` middleware automatically normalizes all incoming request data to the specified Unicode form. To use it, simply add the middleware to your route or middleware group in `app/Http/Kernel.php`:

```php
// app/Http/Kernel.php
protected $middlewareAliases = [
   ...
   'normalizeUnicode' => \Junholee14\LaravelUnicodeNormalizer\Middlewares\NormalizeUnicode::class,
];
```

### Validation Rule
The package also provides a `normalize_unicode` validation rule to ensure that data is in normalized form. You can use this rule like any other Laravel validation rule:

```php
$request->validate([
    'input_field' => ['required', 'string', new NormalizeUnicode()],
]);
```
