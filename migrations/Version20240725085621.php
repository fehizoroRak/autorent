<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240725085621 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE car ADD nbofcardoors INT NOT NULL, ADD nbofpersons INT NOT NULL, ADD airconditionner TINYINT(1) NOT NULL, ADD gearbox VARCHAR(255) NOT NULL, ADD horsepower INT NOT NULL, ADD co2emissions INT NOT NULL, ADD is_electric TINYINT(1) NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE car DROP nbofcardoors, DROP nbofpersons, DROP airconditionner, DROP gearbox, DROP horsepower, DROP co2emissions, DROP is_electric');
    }
}
