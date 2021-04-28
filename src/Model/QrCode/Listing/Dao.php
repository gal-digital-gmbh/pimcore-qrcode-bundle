<?php

namespace GalDigitalGmbh\PimcoreQrcodeBundle\Model\QrCode\Listing;

use GalDigitalGmbh\PimcoreQrcodeBundle\Model\QrCode;
use GalDigitalGmbh\PimcoreQrcodeBundle\Model\QrCode\Listing;
use Pimcore\Model\Dao\PhpArrayTable;

/**
 * @property Listing $model
 */
class Dao extends PhpArrayTable
{
    /**
     * @return void
     */
    public function configure()
    {
        parent::configure();

        $this->setFile('qrcode');
    }

    /**
     * @return QrCode[]
     */
    public function load(): array
    {
        $properties = [];

        foreach ($this->fetchAll() as $propertyData) {
            $property = QrCode::getByName($propertyData['id']);

            if ($property) {
                $properties[] = $property;
            }
        }

        $this->model->setCodes($properties);

        return $properties;
    }

    public function getTotalCount(): int
    {
        return count($this->fetchAll());
    }

    /**
     * @return mixed[]
     */
    private function fetchAll(): array
    {
        return $this->db->fetchAll($this->model->getFilter(), $this->model->getOrder());
    }
}
