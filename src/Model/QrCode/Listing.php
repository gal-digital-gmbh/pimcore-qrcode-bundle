<?php

namespace GalDigitalGmbh\PimcoreQrcodeBundle\Model\QrCode;

use GalDigitalGmbh\PimcoreQrcodeBundle\Model\QrCode;
use GalDigitalGmbh\PimcoreQrcodeBundle\Model\QrCode\Listing\Dao;
use Pimcore\Model\Listing\JsonListing;

/**
 * @method Dao getDao()
 * @method QrCode[] load()
 */
class Listing extends JsonListing
{
    /**
     * @var QrCode[]|null
     */
    protected $codes = null;

    /**
     * @return QrCode[]|null
     */
    public function getCodes()
    {
        if ($this->codes === null) {
            $this->getDao()->load();
        }

        return $this->codes;
    }

    /**
     * @param QrCode[]|null $codes
     */
    public function setCodes(?array $codes): self
    {
        $this->codes = $codes;

        return $this;
    }
}
