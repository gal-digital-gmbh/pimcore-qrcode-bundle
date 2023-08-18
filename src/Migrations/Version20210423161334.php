<?php declare(strict_types = 1);

namespace GalDigitalGmbh\PimcoreQrcodeBundle\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Adds qr_codes admin permissions
 */
final class Version20210423161334 extends AbstractMigration
{
    public function up(Schema $schema): void
    {
        $this->addSql('INSERT IGNORE INTO users_permission_definitions (`key`) VALUES("qr_codes");');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('DELETE FROM users_permission_definitions WHERE `key` = "qr_codes"');
    }
}
