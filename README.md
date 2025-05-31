<div class="filament-hidden">

![Laravel Whatsapp Widget](https://raw.githubusercontent.com/jeffersongoncalves/laravel-whatsapp-widget/master/art/jeffersongoncalves-laravel-whatsapp-widget.png)

</div>

# Laravel Whatsapp Widget

[![Latest Version on Packagist](https://img.shields.io/packagist/v/jeffersongoncalves/laravel-whatsapp-widget.svg?style=flat-square)](https://packagist.org/packages/jeffersongoncalves/laravel-whatsapp-widget)
[![GitHub Tests Action Status](https://img.shields.io/github/actions/workflow/status/jeffersongoncalves/laravel-whatsapp-widget/run-tests.yml?branch=master&label=tests&style=flat-square)](https://github.com/jeffersongoncalves/laravel-whatsapp-widget/actions?query=workflow%3Arun-tests+branch%3Amaster)
[![GitHub Code Style Action Status](https://img.shields.io/github/actions/workflow/status/jeffersongoncalves/laravel-whatsapp-widget/fix-php-code-style-issues.yml?branch=master&label=code%20style&style=flat-square)](https://github.com/jeffersongoncalves/laravel-whatsapp-widget/actions?query=workflow%3A"Fix+PHP+code+styling"+branch%3Amaster)
[![Total Downloads](https://img.shields.io/packagist/dt/jeffersongoncalves/laravel-whatsapp-widget.svg?style=flat-square)](https://packagist.org/packages/jeffersongoncalves/laravel-whatsapp-widget)

This Laravel package provides a simple yet customizable WhatsApp widget for your website. It allows you to easily add a clickable WhatsApp button or floating widget to connect visitors directly with your WhatsApp account. The widget is designed to be easily integrated into your Laravel application and is fully customizable to match your website's design.

## Installation

You can install the package via composer:

```bash
composer require jeffersongoncalves/laravel-whatsapp-widget
```

## Usage

Publish config file.

```bash
php artisan vendor:publish --tag=whatsapp-widget-config
```

Publish migration file.

```bash
php artisan vendor:publish --tag=whatsapp-widget-migrations
```

Publish assets files.

```bash
php artisan vendor:publish --tag=whatsapp-widget-assets
```


Publish translations files.

```bash
php artisan vendor:publish --tag=whatsapp-widget-translations
```

Add head template.

```php
@include('whatsapp-widget::whatsapp-widget-head')
```

Add body template.

```php
@include('whatsapp-widget::whatsapp-widget-body')
```

## Testing

```bash
composer test
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](.github/CONTRIBUTING.md) for details.

## Security Vulnerabilities

Please review [our security policy](../../security/policy) on how to report security vulnerabilities.

## Credits

- [Jèfferson Gonçalves](https://github.com/jeffersongoncalves)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
