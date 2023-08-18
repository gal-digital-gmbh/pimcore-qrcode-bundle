<?php declare(strict_types = 1);

namespace GalDigitalGmbh\PimcoreQrcodeBundle;

use Pimcore\Extension\Bundle\AbstractPimcoreBundle;
use Pimcore\Extension\Bundle\PimcoreBundleAdminClassicInterface;
use Pimcore\Extension\Bundle\Traits\BundleAdminClassicTrait;
use Pimcore\Extension\Bundle\Traits\PackageVersionTrait;

final class PimcoreQrcodeBundle extends AbstractPimcoreBundle implements PimcoreBundleAdminClassicInterface
{
    use BundleAdminClassicTrait;
    use PackageVersionTrait;

    public function getNiceName(): string
    {
        return 'QR-Code Bundle';
    }

    public function getDescription(): string
    {
        return 'Adds a backend configuration view for QR-Codes.';
    }

    public function getJsPaths(): array
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
