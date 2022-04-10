<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220407165206 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE code_departement (id INT AUTO_INCREMENT NOT NULL, libelle VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE departement (id INT AUTO_INCREMENT NOT NULL, code_departement_id INT DEFAULT NULL, region_id INT DEFAULT NULL, lib_departement VARCHAR(255) NOT NULL, abrege_departement VARCHAR(255) NOT NULL, couleur_departement VARCHAR(255) NOT NULL, etat INT NOT NULL, date_creation DATETIME NOT NULL, INDEX IDX_C1765B6387C027E4 (code_departement_id), INDEX IDX_C1765B6398260155 (region_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE localite (id INT AUTO_INCREMENT NOT NULL, libelle VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE membre (id INT AUTO_INCREMENT NOT NULL, region_id INT DEFAULT NULL, profession_id INT DEFAULT NULL, departement_id INT DEFAULT NULL, nom VARCHAR(255) NOT NULL, prenoms VARCHAR(255) NOT NULL, cellule VARCHAR(255) NOT NULL, numero VARCHAR(255) NOT NULL, code_parrainnage VARCHAR(255) NOT NULL, quartier VARCHAR(255) NOT NULL, sexe VARCHAR(255) NOT NULL, date_naissance VARCHAR(255) NOT NULL, lieu_naissance VARCHAR(255) NOT NULL, niveau_etude VARCHAR(255) NOT NULL, nature_piece VARCHAR(255) NOT NULL, numero_piece VARCHAR(255) NOT NULL, lieu_vote VARCHAR(255) NOT NULL, preocupation VARCHAR(255) NOT NULL, numero_carte_electeur VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, contacts VARCHAR(255) NOT NULL, date_creation DATETIME NOT NULL, photo VARCHAR(255) NOT NULL, INDEX IDX_F6B4FB2998260155 (region_id), INDEX IDX_F6B4FB29FDEF8996 (profession_id), INDEX IDX_F6B4FB29CCF9E01E (departement_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE profession (id INT AUTO_INCREMENT NOT NULL, libelle VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE departement ADD CONSTRAINT FK_C1765B6387C027E4 FOREIGN KEY (code_departement_id) REFERENCES code_departement (id)');
        $this->addSql('ALTER TABLE departement ADD CONSTRAINT FK_C1765B6398260155 FOREIGN KEY (region_id) REFERENCES localite (id)');
        $this->addSql('ALTER TABLE membre ADD CONSTRAINT FK_F6B4FB2998260155 FOREIGN KEY (region_id) REFERENCES localite (id)');
        $this->addSql('ALTER TABLE membre ADD CONSTRAINT FK_F6B4FB29FDEF8996 FOREIGN KEY (profession_id) REFERENCES profession (id)');
        $this->addSql('ALTER TABLE membre ADD CONSTRAINT FK_F6B4FB29CCF9E01E FOREIGN KEY (departement_id) REFERENCES departement (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE departement DROP FOREIGN KEY FK_C1765B6387C027E4');
        $this->addSql('ALTER TABLE membre DROP FOREIGN KEY FK_F6B4FB29CCF9E01E');
        $this->addSql('ALTER TABLE departement DROP FOREIGN KEY FK_C1765B6398260155');
        $this->addSql('ALTER TABLE membre DROP FOREIGN KEY FK_F6B4FB2998260155');
        $this->addSql('ALTER TABLE membre DROP FOREIGN KEY FK_F6B4FB29FDEF8996');
        $this->addSql('DROP TABLE code_departement');
        $this->addSql('DROP TABLE departement');
        $this->addSql('DROP TABLE localite');
        $this->addSql('DROP TABLE membre');
        $this->addSql('DROP TABLE profession');
    }
}
