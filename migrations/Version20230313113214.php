<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230313113214 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE realisation (id INT AUTO_INCREMENT NOT NULL, id_client_id INT NOT NULL, adresse VARCHAR(255) DEFAULT NULL, cp VARCHAR(255) DEFAULT NULL, ville VARCHAR(255) DEFAULT NULL, prix VARCHAR(255) DEFAULT NULL, date DATE DEFAULT NULL, INDEX IDX_EAA5610E99DED506 (id_client_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE realisation_technicien (realisation_id INT NOT NULL, technicien_id INT NOT NULL, INDEX IDX_25136676B685E551 (realisation_id), INDEX IDX_2513667613457256 (technicien_id), PRIMARY KEY(realisation_id, technicien_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE realisation ADD CONSTRAINT FK_EAA5610E99DED506 FOREIGN KEY (id_client_id) REFERENCES client (id)');
        $this->addSql('ALTER TABLE realisation_technicien ADD CONSTRAINT FK_25136676B685E551 FOREIGN KEY (realisation_id) REFERENCES realisation (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE realisation_technicien ADD CONSTRAINT FK_2513667613457256 FOREIGN KEY (technicien_id) REFERENCES technicien (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE realisation DROP FOREIGN KEY FK_EAA5610E99DED506');
        $this->addSql('ALTER TABLE realisation_technicien DROP FOREIGN KEY FK_25136676B685E551');
        $this->addSql('ALTER TABLE realisation_technicien DROP FOREIGN KEY FK_2513667613457256');
        $this->addSql('DROP TABLE realisation');
        $this->addSql('DROP TABLE realisation_technicien');
    }
}
