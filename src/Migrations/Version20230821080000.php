<?php declare(strict_types = 1);

namespace GalDigitalGmbh\PimcoreQrcodeBundle\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Adds category to qr_codes admin permissions
 */
final class Version20230821080000 extends AbstractMigration
{
    public function up(Schema $schema): void
    {
        $this->addSql('UPDATE users_permission_definitions SET category = "Pimcore QR-Code Bundle" WHERE `key` = "qr_codes";');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('UPDATE users_permission_definitions SET category = "" WHERE `key` = "qr_codes";');
    }
}
