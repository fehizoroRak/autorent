<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240728224320 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE location_option (location_id INT NOT NULL, option_id INT NOT NULL, INDEX IDX_11F488B264D218E (location_id), INDEX IDX_11F488B2A7C41D6F (option_id), PRIMARY KEY(location_id, option_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE `option` (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, price DOUBLE PRECISION NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE pack (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, price_per_day DOUBLE PRECISION NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE location_option ADD CONSTRAINT FK_11F488B264D218E FOREIGN KEY (location_id) REFERENCES location (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE location_option ADD CONSTRAINT FK_11F488B2A7C41D6F FOREIGN KEY (option_id) REFERENCES `option` (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE location ADD pack_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE location ADD CONSTRAINT FK_5E9E89CB1919B217 FOREIGN KEY (pack_id) REFERENCES pack (id)');
        $this->addSql('CREATE INDEX IDX_5E9E89CB1919B217 ON location (pack_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE location DROP FOREIGN KEY FK_5E9E89CB1919B217');
        $this->addSql('ALTER TABLE location_option DROP FOREIGN KEY FK_11F488B264D218E');
        $this->addSql('ALTER TABLE location_option DROP FOREIGN KEY FK_11F488B2A7C41D6F');
        $this->addSql('DROP TABLE location_option');
        $this->addSql('DROP TABLE `option`');
        $this->addSql('DROP TABLE pack');
        $this->addSql('DROP INDEX IDX_5E9E89CB1919B217 ON location');
        $this->addSql('ALTER TABLE location DROP pack_id');
    }
}
