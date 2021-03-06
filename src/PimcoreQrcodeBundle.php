<?php

namespace GalDigitalGmbh\PimcoreQrcodeBundle;

use Pimcore\Extension\Bundle\AbstractPimcoreBundle;
use Pimcore\Extension\Bundle\Traits\PackageVersionTrait;
use Pimcore\Extension\Bundle\Traits\StateHelperTrait;

class PimcoreQrcodeBundle extends AbstractPimcoreBundle
{
    use StateHelperTrait;
    use PackageVersionTrait;

    public function getNiceName()
    {
        return 'QR-Code Bundle';
    }

    public function getDescription()
    {
        return 'Adds a backend configuration view for QR-Codes.';
    }

    public function getJsPaths()
    {
        return [
            '/bundles/pimcoreqrcode/admin/js/startup.js',
            '/bundles/pimcoreqrcode/admin/js/panel.js',
            '/bundles/pimcoreqrcode/admin/js/item.js',
        ];
    }

    protected function getComposerPackageName(): string
    {
        return 'gal-digital-gmbh/pimcore-qrcode-bundle';
    }
}
