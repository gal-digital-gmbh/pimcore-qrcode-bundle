# Pimcore QR-Code bundle

Adds a backend configuration view for QR-Codes.

## Installation

Require the bundle

```bash
composer require gal-digital-gmbh/pimcore-qrcode-bundle
```

Add the bundle to your `config/bundles.php` configuration

```php
<?php

return [
  GalDigital\QrCodeBundle\QrCodeBundle::class => ['all' => true],
];
```

Install project assets with arguments depending on your setup

```bash
php bin/console assets:install --relative --symlink public
```
