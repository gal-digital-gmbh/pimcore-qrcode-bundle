# Pimcore QR-Code bundle

Adds a backend configuration view for QR-Codes.

## Requirements

Pimcore >= 11.0

## Installation

Require the bundle

```bash
composer require gal-digital-gmbh/pimcore-qrcode-bundle
```

Add the bundle to the `config/bundles.php` file to enable it. The following lines should be added:

```php
use GalDigitalGmbh\PimcoreQrcodeBundle\PimcoreQrcodeBundle;
// ...

return [
    // ...
    PimcoreQrcodeBundle::class => ['all' => true],
    // ...
];
```
