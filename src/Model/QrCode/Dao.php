<?php

namespace GalDigitalGmbh\QrCodeBundle\Model\QrCode;

use Exception;
use GalDigitalGmbh\QrCodeBundle\Model\QrCode;
use Pimcore\Model\Dao\PhpArrayTable;

/**
 * @property QrCode $model
 */
class Dao extends PhpArrayTable
{
    /**
     * @var string[]
     */
    private static $allowedProperties = [
        'name',
        'description',
        'url',
        'creationDate',
        'modificationDate',
    ];

    /**
     * @return void
     */
    public function configure()
    {
        parent::configure();

        $this->setFile('qrcode');
    }

    /**
     * @throws Exception
     */
    public function getByName(?string $id = null): void
    {
        if ($id !== null) {
            $this->model->setName($id);
        }

        $name = $this->model->getName();
        $data = $this->db->getById($name);

        if (!isset($data['id'])) {
            throw new Exception('QR-Code with id: ' . $name . ' does not exist');
        }

        $this->assignVariablesToModel($data);
        $this->model->setName($data['id']);
    }

    /**
     * @throws Exception
     */
    public function save(): void
    {
        $time = time();

        if (!$this->model->getCreationDate()) {
            $this->model->setCreationDate($time);
        }

        $this->model->setModificationDate($time);

        $rawData = $this->model->getObjectVars();

        $data = array_filter($rawData, function ($property) {
            return in_array($property, self::$allowedProperties);
        }, ARRAY_FILTER_USE_KEY);

        $this->db->insertOrUpdate($data, $this->model->getName());
    }

    public function delete(): void
    {
        $this->db->delete($this->model->getName());
    }
}
