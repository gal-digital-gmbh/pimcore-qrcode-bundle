<?php

namespace GalDigitalGmbh\PimcoreQrcodeBundle\EventListener;

use GalDigitalGmbh\PimcoreQrcodeBundle\Model\QrCode;
use Pimcore\Event\Admin\IndexActionSettingsEvent;

class AdminListener
{
    /**
     * Handles INDEX_ACTION_SETTINGS event and adds custom admin UI settings
     *
     * @param IndexActionSettingsEvent $event
     */
    public function addIndexSettings(IndexActionSettingsEvent $event)
    {
        $event->addSetting('qrcode-writeable', (new QrCode())->isWriteable());
    }
}
