<?php

namespace GalDigitalGmbh\QrCodeBundle;

use GalDigitalGmbh\QrCodeBundle\DependencyInjection\QrCodeExtension;
use Pimcore\Extension\Bundle\AbstractPimcoreBundle;

class QrCodeBundle extends AbstractPimcoreBundle
{
    public function getContainerExtension()
    {
        return new QrCodeExtension();
    }

    public function getJsPaths()
    {
        return [
            '/bundles/qrcode/admin/js/startup.js',
            '/bundles/qrcode/admin/js/panel.js',
            '/bundles/qrcode/admin/js/item.js',
        ];
    }
}
