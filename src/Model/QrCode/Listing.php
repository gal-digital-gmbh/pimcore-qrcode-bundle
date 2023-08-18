<?php declare(strict_types = 1);

namespace GalDigitalGmbh\PimcoreQrcodeBundle\Model\QrCode;

use GalDigitalGmbh\PimcoreQrcodeBundle\Model\QrCode;
use GalDigitalGmbh\PimcoreQrcodeBundle\Model\QrCode\Listing\Dao;
use Pimcore\Model\AbstractModel;
use Pimcore\Model\Listing\Traits\FilterListingTrait;
use Pimcore\Model\Listing\Traits\OrderListingTrait;

/**
 * @method Dao getDao()
 */
final class Listing extends AbstractModel
{
    use FilterListingTrait;
    use OrderListingTrait;

    /**
     * @var QrCode[]|null
     */
    protected ?array $codes = null;

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
     * @return QrCode[]
     */
    public function load(): array
    {
        return $this->getCodes();
    }
}
