<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240801223908 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE status (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, description LONGTEXT DEFAULT NULL, color VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE status_location (status_id INT NOT NULL, location_id INT NOT NULL, INDEX IDX_C3442E136BF700BD (status_id), INDEX IDX_C3442E1364D218E (location_id), PRIMARY KEY(status_id, location_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE status_location ADD CONSTRAINT FK_C3442E136BF700BD FOREIGN KEY (status_id) REFERENCES status (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE status_location ADD CONSTRAINT FK_C3442E1364D218E FOREIGN KEY (location_id) REFERENCES location (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE location ADD number_of_days INT DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE status_location DROP FOREIGN KEY FK_C3442E136BF700BD');
        $this->addSql('ALTER TABLE status_location DROP FOREIGN KEY FK_C3442E1364D218E');
        $this->addSql('DROP TABLE status');
        $this->addSql('DROP TABLE status_location');
        $this->addSql('ALTER TABLE location DROP number_of_days');
    }
}
