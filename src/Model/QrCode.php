<?php declare(strict_types = 1);

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
final class QrCode extends AbstractModel
{
    public string $name = '';

    public string $description = '';

    public string $url = '';

    public int $modificationDate = 0;

    public int $creationDate = 0;

    public static function getByName(string $name): ?self
    {
        try {
            $code = new self();
            $code->getDao()->getByName($name);

            return $code;
        } catch (NotFoundException) {
            return null;
        }
    }

    /**
     * @return $this
     */
    public function setDescription(string $description): self
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
    public function setName(string $name): self
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
    public function setUrl(string $url): self
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
    public function setModificationDate(int $modificationDate): self
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
