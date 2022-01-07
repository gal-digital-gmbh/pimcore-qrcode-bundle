<?php

namespace GalDigitalGmbh\PimcoreQrcodeBundle\Model;

use GalDigitalGmbh\PimcoreQrcodeBundle\Model\QrCode\Dao;
use Pimcore\Model\AbstractModel;
use Pimcore\Model\Exception\NotFoundException;

/**
 * @method Dao getDao()
 * @method bool isWriteable()
 * @method void delete()
 * @method void save()
 */
class QrCode extends AbstractModel
{
    /**
     * @var string
     */
    public $name = '';

    /**
     * @var string
     */
    public $description = '';

    /**
     * @var string
     */
    public $url = '';

    /**
     * @var int
     */
    public $modificationDate = 0;

    /**
     * @var int
     */
    public $creationDate = 0;

    public static function getByName(string $name): ?self
    {
        try {
            $code = new self();
            $code->getDao()->getByName($name);

            return $code;
        } catch (NotFoundException $e) {
            return null;
        }
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setUrl(string $url): self
    {
        $this->url = $url;

        return $this;
    }

    public function getUrl(): string
    {
        return $this->url;
    }

    public function setModificationDate(int $modificationDate): self
    {
        $this->modificationDate = $modificationDate;

        return $this;
    }

    public function getModificationDate(): int
    {
        return $this->modificationDate;
    }

    public function setCreationDate(int $creationDate): self
    {
        $this->creationDate = $creationDate;

        return $this;
    }

    public function getCreationDate(): int
    {
        return $this->creationDate;
    }
}
