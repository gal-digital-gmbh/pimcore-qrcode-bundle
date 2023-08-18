<?php declare(strict_types = 1);

namespace GalDigitalGmbh\PimcoreQrcodeBundle\Model\QrCode;

use Exception;
use GalDigitalGmbh\PimcoreQrcodeBundle\Model\QrCode;
use Pimcore\Model\Dao\PimcoreLocationAwareConfigDao;
use Pimcore\Model\Exception\NotFoundException;

/**
 * @property QrCode $model
 *
 * @internal
 */
class Dao extends PimcoreLocationAwareConfigDao
{
    /**
     * @var string[]
     */
    private static array $allowedProperties = [
        'name',
        'description',
        'url',
        'creationDate',
        'modificationDate',
    ];

    public function configure(): void
    {
        /** @var array<mixed>|null $config */
        $config = \Pimcore::getContainer()?->getParameter('pimcore_qrcode');
        $storageConfig = $config['config_location']['qrcode'];

        parent::configure([
            'containerConfig' => $config['configurations'] ?? [],
            'settingsStoreScope' => 'pimcore_qrcode',
            'storageConfig' => $storageConfig,
        ]);
    }

    public function getByName(string $name): void
    {
        $data = $this->getDataByName($name);

        if ($data) {
            $this->assignVariablesToModel($data);
        } else {
            throw new NotFoundException('QR-Code with name: ' . $name . ' does not exist');
        }
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

        $this->saveData($this->model->getName(), $data);
    }

    public function delete(): void
    {
        $this->deleteData($this->model->getName());
    }

    protected function prepareDataStructureForYaml(string $id, mixed $data): mixed
    {
        return [
            'pimcore_qrcode' => [
                'codes' => [
                    $id => $data,
                ],
            ],
        ];
    }
}
