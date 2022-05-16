<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220513090110 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE client (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, prenom VARCHAR(255) NOT NULL, date_naissance DATETIME NOT NULL, lieu_naissance VARCHAR(255) NOT NULL, profession VARCHAR(255) NOT NULL, domicile VARCHAR(255) NOT NULL, pere VARCHAR(255) NOT NULL, mere VARCHAR(255) NOT NULL, etat_bien_vendu VARCHAR(255) NOT NULL, adresse VARCHAR(255) NOT NULL, tel_domicile VARCHAR(255) NOT NULL, tel_bureau VARCHAR(255) NOT NULL, tel_portable VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, nationalite VARCHAR(255) NOT NULL, situation VARCHAR(255) NOT NULL, nom_conjoint VARCHAR(255) NOT NULL, prenom_conjoint VARCHAR(255) NOT NULL, date_naissance_conjoint DATETIME NOT NULL, lieu_naissance_conjoint VARCHAR(255) NOT NULL, profession_conjoint VARCHAR(255) NOT NULL, pere_conjoint VARCHAR(255) NOT NULL, mere_conjoint VARCHAR(255) NOT NULL, adresse_conjoint VARCHAR(255) NOT NULL, nationalite_conjoint VARCHAR(255) NOT NULL, regime_matrimonial_conjoint VARCHAR(255) NOT NULL, date_mariage DATETIME NOT NULL, lieu_mariage_conjoint VARCHAR(255) NOT NULL, contrat_mariage_conjoint VARCHAR(255) NOT NULL, affirmatif VARCHAR(255) NOT NULL, precedent_mariage VARCHAR(255) NOT NULL, nom_prenom_epoux VARCHAR(255) NOT NULL, date_precedent DATETIME NOT NULL, regime VARCHAR(255) NOT NULL, numero_jugement VARCHAR(255) NOT NULL, date_jugement DATETIME NOT NULL, jugement_rendu VARCHAR(255) NOT NULL, date_deces DATETIME NOT NULL, lieu_deces VARCHAR(255) NOT NULL, fait_le DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE courier_arrive (id INT AUTO_INCREMENT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE calendar ADD client_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE calendar ADD CONSTRAINT FK_6EA9A14619EB6921 FOREIGN KEY (client_id) REFERENCES client (id)');
        $this->addSql('CREATE INDEX IDX_6EA9A14619EB6921 ON calendar (client_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE calendar DROP FOREIGN KEY FK_6EA9A14619EB6921');
        $this->addSql('DROP TABLE client');
        $this->addSql('DROP TABLE courier_arrive');
        $this->addSql('DROP INDEX IDX_6EA9A14619EB6921 ON calendar');
        $this->addSql('ALTER TABLE calendar DROP client_id');
    }
}
