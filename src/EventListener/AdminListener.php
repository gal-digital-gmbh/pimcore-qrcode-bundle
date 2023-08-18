<?php declare(strict_types = 1);

namespace GalDigitalGmbh\PimcoreQrcodeBundle\EventListener;

use GalDigitalGmbh\PimcoreQrcodeBundle\Model\QrCode;
use Pimcore\Bundle\AdminBundle\Event\IndexActionSettingsEvent;

final class AdminListener
{
    /**
     * Handles INDEX_ACTION_SETTINGS event and adds custom admin UI settings
     *
     * @param IndexActionSettingsEvent $event
     */
    public function addIndexSettings(IndexActionSettingsEvent $event): void
    {
        $event->addSetting('qrcode-writeable', (new QrCode())->isWriteable());
    }
}
