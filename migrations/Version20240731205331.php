<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240731205331 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE `option` ADD image VARCHAR(255) DEFAULT NULL, ADD content LONGTEXT DEFAULT NULL');
        $this->addSql('ALTER TABLE pack ADD franchise DOUBLE PRECISION DEFAULT NULL, ADD content1 LONGTEXT DEFAULT NULL, ADD content2 LONGTEXT DEFAULT NULL, ADD content3 LONGTEXT DEFAULT NULL, ADD content4 LONGTEXT DEFAULT NULL, ADD content5 LONGTEXT DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE `option` DROP image, DROP content');
        $this->addSql('ALTER TABLE pack DROP franchise, DROP content1, DROP content2, DROP content3, DROP content4, DROP content5');
    }
}
