<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230213221942 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE properti ADD surface INT NOT NULL, ADD rooms INT NOT NULL, ADD bedrooms INT NOT NULL, ADD floor INT NOT NULL, ADD price INT NOT NULL, ADD heat INT NOT NULL, ADD city VARCHAR(255) NOT NULL, ADD adresse VARCHAR(255) NOT NULL, ADD sold TINYINT(1) NOT NULL, ADD created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', ADD postal_code INT NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE properti DROP surface, DROP rooms, DROP bedrooms, DROP floor, DROP price, DROP heat, DROP city, DROP adresse, DROP sold, DROP created_at, DROP postal_code');
    }
}
