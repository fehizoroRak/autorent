<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240728221131 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE city_dropoff_location (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE city_pickup_location (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE location ADD pickup_location_id INT NOT NULL, ADD dropoff_location_id INT NOT NULL, DROP pickup_location, DROP dropoff_location');
        $this->addSql('ALTER TABLE location ADD CONSTRAINT FK_5E9E89CBC77EA60D FOREIGN KEY (pickup_location_id) REFERENCES city_pickup_location (id)');
        $this->addSql('ALTER TABLE location ADD CONSTRAINT FK_5E9E89CB11CB64C5 FOREIGN KEY (dropoff_location_id) REFERENCES city_dropoff_location (id)');
        $this->addSql('CREATE INDEX IDX_5E9E89CBC77EA60D ON location (pickup_location_id)');
        $this->addSql('CREATE INDEX IDX_5E9E89CB11CB64C5 ON location (dropoff_location_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE location DROP FOREIGN KEY FK_5E9E89CB11CB64C5');
        $this->addSql('ALTER TABLE location DROP FOREIGN KEY FK_5E9E89CBC77EA60D');
        $this->addSql('DROP TABLE city_dropoff_location');
        $this->addSql('DROP TABLE city_pickup_location');
        $this->addSql('DROP INDEX IDX_5E9E89CBC77EA60D ON location');
        $this->addSql('DROP INDEX IDX_5E9E89CB11CB64C5 ON location');
        $this->addSql('ALTER TABLE location ADD pickup_location VARCHAR(255) NOT NULL, ADD dropoff_location VARCHAR(255) NOT NULL, DROP pickup_location_id, DROP dropoff_location_id');
    }
}
