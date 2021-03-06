<?php

namespace GalDigitalGmbh\PimcoreQrcodeBundle\Model\QrCode;

use GalDigitalGmbh\PimcoreQrcodeBundle\Model\QrCode;
use GalDigitalGmbh\PimcoreQrcodeBundle\Model\QrCode\Listing\Dao;
use Pimcore\Model\Listing\JsonListing;

/**
 * @method Dao getDao()
 */
class Listing extends JsonListing
{
    /**
     * @var QrCode[]|null
     */
    protected $codes = null;

    /**
     * @return QrCode[]
     */
    public function getCodes(): array
    {
        if ($this->codes === null) {
            return $this->getDao()->loadList();
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

    /**
     * @return QrCode[]|null
     */
    public function load()
    {
        return $this->getCodes();
    }
}
