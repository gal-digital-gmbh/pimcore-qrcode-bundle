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
    public string $name = '';

    /**
     * @var string
     */
    public string $description = '';

    /**
     * @var string
     */
    public string $url = '';

    /**
     * @var int
     */
    public int $modificationDate = 0;

    /**
     * @var int
     */
    public int $creationDate = 0;

    public static function getByName(string $name): ?static
    {
        try {
            $code = new static();
            $code->getDao()->getByName($name);

            return $code;
        } catch (NotFoundException) {
            return null;
        }
    }

    /**
     * @return $this
     */
    public function setDescription(string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * @return $this
     */
    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return $this
     */
    public function setUrl(string $url): static
    {
        $this->url = $url;

        return $this;
    }

    public function getUrl(): string
    {
        return $this->url;
    }

    /**
     * @return $this
     */
    public function setModificationDate(int $modificationDate): static
    {
        $this->modificationDate = $modificationDate;

        return $this;
    }

    public function getModificationDate(): int
    {
        return $this->modificationDate;
    }

    /**
     * @return $this
     */
    public function setCreationDate(int $creationDate): static
    {
        $this->creationDate = $creationDate;

        return $this;
    }

    public function getCreationDate(): int
    {
        return $this->creationDate;
    }
}
