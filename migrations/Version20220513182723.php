<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220513182723 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE client CHANGE prenom_conjoint prenom_conjoint VARCHAR(255) DEFAULT NULL, CHANGE date_naissance_conjoint date_naissance_conjoint DATETIME DEFAULT NULL, CHANGE lieu_naissance_conjoint lieu_naissance_conjoint VARCHAR(255) DEFAULT NULL, CHANGE profession_conjoint profession_conjoint VARCHAR(255) DEFAULT NULL, CHANGE pere_conjoint pere_conjoint VARCHAR(255) DEFAULT NULL, CHANGE mere_conjoint mere_conjoint VARCHAR(255) DEFAULT NULL, CHANGE adresse_conjoint adresse_conjoint VARCHAR(255) DEFAULT NULL, CHANGE nationalite_conjoint nationalite_conjoint VARCHAR(255) DEFAULT NULL, CHANGE regime_matrimonial_conjoint regime_matrimonial_conjoint VARCHAR(255) DEFAULT NULL, CHANGE date_mariage date_mariage DATETIME DEFAULT NULL, CHANGE lieu_mariage_conjoint lieu_mariage_conjoint VARCHAR(255) DEFAULT NULL, CHANGE contrat_mariage_conjoint contrat_mariage_conjoint VARCHAR(255) DEFAULT NULL, CHANGE affirmatif affirmatif VARCHAR(255) DEFAULT NULL, CHANGE precedent_mariage precedent_mariage VARCHAR(255) DEFAULT NULL, CHANGE nom_prenom_epoux nom_prenom_epoux VARCHAR(255) DEFAULT NULL, CHANGE date_precedent date_precedent DATETIME DEFAULT NULL, CHANGE regime regime VARCHAR(255) DEFAULT NULL, CHANGE numero_jugement numero_jugement VARCHAR(255) DEFAULT NULL, CHANGE date_jugement date_jugement DATETIME DEFAULT NULL, CHANGE jugement_rendu jugement_rendu VARCHAR(255) DEFAULT NULL, CHANGE date_deces date_deces DATETIME DEFAULT NULL, CHANGE lieu_deces lieu_deces VARCHAR(255) DEFAULT NULL, CHANGE fait_le fait_le DATETIME DEFAULT NULL, CHANGE email_conjoint email_conjoint VARCHAR(255) DEFAULT NULL, CHANGE tel_conjoint tel_conjoint VARCHAR(255) DEFAULT NULL, CHANGE portable_conjoint portable_conjoint VARCHAR(255) DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE client CHANGE prenom_conjoint prenom_conjoint VARCHAR(255) NOT NULL, CHANGE date_naissance_conjoint date_naissance_conjoint DATETIME NOT NULL, CHANGE lieu_naissance_conjoint lieu_naissance_conjoint VARCHAR(255) NOT NULL, CHANGE profession_conjoint profession_conjoint VARCHAR(255) NOT NULL, CHANGE pere_conjoint pere_conjoint VARCHAR(255) NOT NULL, CHANGE mere_conjoint mere_conjoint VARCHAR(255) NOT NULL, CHANGE adresse_conjoint adresse_conjoint VARCHAR(255) NOT NULL, CHANGE nationalite_conjoint nationalite_conjoint VARCHAR(255) NOT NULL, CHANGE regime_matrimonial_conjoint regime_matrimonial_conjoint VARCHAR(255) NOT NULL, CHANGE date_mariage date_mariage DATETIME NOT NULL, CHANGE lieu_mariage_conjoint lieu_mariage_conjoint VARCHAR(255) NOT NULL, CHANGE contrat_mariage_conjoint contrat_mariage_conjoint VARCHAR(255) NOT NULL, CHANGE affirmatif affirmatif VARCHAR(255) NOT NULL, CHANGE precedent_mariage precedent_mariage VARCHAR(255) NOT NULL, CHANGE nom_prenom_epoux nom_prenom_epoux VARCHAR(255) NOT NULL, CHANGE date_precedent date_precedent DATETIME NOT NULL, CHANGE regime regime VARCHAR(255) NOT NULL, CHANGE numero_jugement numero_jugement VARCHAR(255) NOT NULL, CHANGE date_jugement date_jugement DATETIME NOT NULL, CHANGE jugement_rendu jugement_rendu VARCHAR(255) NOT NULL, CHANGE date_deces date_deces DATETIME NOT NULL, CHANGE lieu_deces lieu_deces VARCHAR(255) NOT NULL, CHANGE fait_le fait_le DATETIME NOT NULL, CHANGE email_conjoint email_conjoint VARCHAR(255) NOT NULL, CHANGE tel_conjoint tel_conjoint VARCHAR(255) NOT NULL, CHANGE portable_conjoint portable_conjoint VARCHAR(255) NOT NULL');
    }
}
