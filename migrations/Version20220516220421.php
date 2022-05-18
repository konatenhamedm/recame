<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220516220421 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE acte (id INT AUTO_INCREMENT NOT NULL, vendeur_id INT DEFAULT NULL, acheteur_id INT DEFAULT NULL, type_id INT DEFAULT NULL, date DATETIME DEFAULT NULL, objet VARCHAR(255) NOT NULL, montant DOUBLE PRECISION NOT NULL, active VARCHAR(255) NOT NULL, numero VARCHAR(255) NOT NULL, INDEX IDX_9EC41326858C065E (vendeur_id), INDEX IDX_9EC4132696A7BB5F (acheteur_id), INDEX IDX_9EC41326C54C8C93 (type_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE calendar (id INT AUTO_INCREMENT NOT NULL, client_id INT DEFAULT NULL, title VARCHAR(255) NOT NULL, start DATETIME NOT NULL, end DATETIME NOT NULL, description LONGTEXT NOT NULL, all_day TINYINT(1) NOT NULL, background_color VARCHAR(7) NOT NULL, border_color VARCHAR(7) NOT NULL, text_color VARCHAR(7) NOT NULL, active VARCHAR(255) NOT NULL, INDEX IDX_6EA9A14619EB6921 (client_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE categorie (id INT AUTO_INCREMENT NOT NULL, libelle VARCHAR(255) NOT NULL, image VARCHAR(255) NOT NULL, description LONGTEXT NOT NULL, status VARCHAR(255) NOT NULL, active INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE chambre (id INT AUTO_INCREMENT NOT NULL, libelle VARCHAR(255) NOT NULL, prix DOUBLE PRECISION NOT NULL, image VARCHAR(255) NOT NULL, active INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE client (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, prenom VARCHAR(255) NOT NULL, date_naissance DATETIME NOT NULL, lieu_naissance VARCHAR(255) NOT NULL, profession VARCHAR(255) DEFAULT NULL, domicile VARCHAR(255) DEFAULT NULL, pere VARCHAR(255) DEFAULT NULL, mere VARCHAR(255) DEFAULT NULL, etat_bien_vendu VARCHAR(255) DEFAULT NULL, adresse VARCHAR(255) DEFAULT NULL, tel_domicile VARCHAR(255) DEFAULT NULL, tel_bureau VARCHAR(255) DEFAULT NULL, tel_portable VARCHAR(255) NOT NULL, email VARCHAR(255) DEFAULT NULL, nationalite VARCHAR(255) DEFAULT NULL, situation VARCHAR(255) DEFAULT NULL, nom_conjoint VARCHAR(255) DEFAULT NULL, prenom_conjoint VARCHAR(255) DEFAULT NULL, date_naissance_conjoint DATETIME DEFAULT NULL, lieu_naissance_conjoint VARCHAR(255) DEFAULT NULL, profession_conjoint VARCHAR(255) DEFAULT NULL, pere_conjoint VARCHAR(255) DEFAULT NULL, mere_conjoint VARCHAR(255) DEFAULT NULL, adresse_conjoint VARCHAR(255) DEFAULT NULL, nationalite_conjoint VARCHAR(255) DEFAULT NULL, regime_matrimonial_conjoint VARCHAR(255) DEFAULT NULL, date_mariage DATETIME DEFAULT NULL, lieu_mariage_conjoint VARCHAR(255) DEFAULT NULL, contrat_mariage_conjoint VARCHAR(255) DEFAULT NULL, affirmatif VARCHAR(255) DEFAULT NULL, precedent_mariage VARCHAR(255) DEFAULT NULL, nom_prenom_epoux VARCHAR(255) DEFAULT NULL, date_precedent DATETIME DEFAULT NULL, regime VARCHAR(255) DEFAULT NULL, numero_jugement VARCHAR(255) DEFAULT NULL, date_jugement DATETIME DEFAULT NULL, jugement_rendu VARCHAR(255) DEFAULT NULL, date_deces DATETIME DEFAULT NULL, lieu_deces VARCHAR(255) DEFAULT NULL, fait_le DATETIME DEFAULT NULL, active VARCHAR(255) NOT NULL, photo VARCHAR(255) NOT NULL, email_conjoint VARCHAR(255) DEFAULT NULL, tel_conjoint VARCHAR(255) DEFAULT NULL, portable_conjoint VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE contact (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, prenom VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, telephone VARCHAR(255) NOT NULL, message LONGTEXT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE courier_arrive (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, exp_id INT DEFAULT NULL, expediteur_id INT DEFAULT NULL, recep_id INT DEFAULT NULL, numero VARCHAR(255) NOT NULL, date_reception DATETIME NOT NULL, objet LONGTEXT NOT NULL, categorie VARCHAR(255) NOT NULL, active VARCHAR(255) NOT NULL, etat TINYINT(1) DEFAULT NULL, type VARCHAR(255) NOT NULL, existe TINYINT(1) DEFAULT NULL, rangement VARCHAR(255) NOT NULL, reference VARCHAR(255) NOT NULL, INDEX IDX_90FA9925A76ED395 (user_id), INDEX IDX_90FA9925D26628FA (exp_id), INDEX IDX_90FA992510335F61 (expediteur_id), INDEX IDX_90FA99257F5413B1 (recep_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE departement (id INT AUTO_INCREMENT NOT NULL, region_id INT DEFAULT NULL, lib_departement VARCHAR(255) NOT NULL, active INT NOT NULL, INDEX IDX_C1765B6398260155 (region_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE fichier (id INT AUTO_INCREMENT NOT NULL, arrive_id INT DEFAULT NULL, path VARCHAR(255) NOT NULL, INDEX IDX_9B76551FF4028648 (arrive_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE fichier_acte (id INT AUTO_INCREMENT NOT NULL, acte_id INT DEFAULT NULL, titre VARCHAR(255) NOT NULL, path VARCHAR(255) NOT NULL, INDEX IDX_1F4BDBCDA767B8C7 (acte_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE groupe (id INT AUTO_INCREMENT NOT NULL, module_id INT DEFAULT NULL, icon_id INT DEFAULT NULL, titre VARCHAR(255) NOT NULL, lien VARCHAR(255) NOT NULL, ordre INT NOT NULL, INDEX IDX_4B98C21AFC2B591 (module_id), INDEX IDX_4B98C2154B9D732 (icon_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE icons (id INT AUTO_INCREMENT NOT NULL, code VARCHAR(255) NOT NULL, image VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE image (id INT AUTO_INCREMENT NOT NULL, produit_id INT DEFAULT NULL, image VARCHAR(255) NOT NULL, titre VARCHAR(255) NOT NULL, description LONGTEXT NOT NULL, INDEX IDX_C53D045FF347EFB (produit_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE images (id INT AUTO_INCREMENT NOT NULL, chambre_id INT DEFAULT NULL, path VARCHAR(255) NOT NULL, libelle VARCHAR(255) NOT NULL, INDEX IDX_E01FBE6A9B177F54 (chambre_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE localite (id INT AUTO_INCREMENT NOT NULL, libelle VARCHAR(255) NOT NULL, active INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE marque (id INT AUTO_INCREMENT NOT NULL, libelle VARCHAR(255) NOT NULL, logo VARCHAR(255) NOT NULL, active INT DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE membre (id INT AUTO_INCREMENT NOT NULL, region_id INT DEFAULT NULL, profession_id INT DEFAULT NULL, departement_id INT DEFAULT NULL, nom VARCHAR(255) NOT NULL, prenoms VARCHAR(255) NOT NULL, cellule VARCHAR(255) NOT NULL, numero VARCHAR(255) NOT NULL, code_parrainnage VARCHAR(255) NOT NULL, quartier VARCHAR(255) NOT NULL, sexe VARCHAR(255) NOT NULL, date_naissance DATETIME NOT NULL, lieu_naissance VARCHAR(255) NOT NULL, niveau_etude VARCHAR(255) NOT NULL, nature_piece VARCHAR(255) NOT NULL, numero_piece VARCHAR(255) NOT NULL, lieu_vote VARCHAR(255) NOT NULL, preocupation VARCHAR(255) NOT NULL, numero_carte_electeur VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, contacts VARCHAR(255) NOT NULL, date_creation DATETIME NOT NULL, photo VARCHAR(255) NOT NULL, active INT NOT NULL, INDEX IDX_F6B4FB2998260155 (region_id), INDEX IDX_F6B4FB29FDEF8996 (profession_id), INDEX IDX_F6B4FB29CCF9E01E (departement_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE module (id INT AUTO_INCREMENT NOT NULL, parent_id INT DEFAULT NULL, icon_id INT DEFAULT NULL, titre VARCHAR(255) NOT NULL, ordre INT NOT NULL, active INT NOT NULL, INDEX IDX_C242628727ACA70 (parent_id), INDEX IDX_C24262854B9D732 (icon_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE module_parent (id INT AUTO_INCREMENT NOT NULL, titre VARCHAR(255) NOT NULL, ordre INT NOT NULL, active INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE parametre (id INT AUTO_INCREMENT NOT NULL, titre VARCHAR(255) NOT NULL, logo VARCHAR(255) NOT NULL, couleur_header VARCHAR(255) NOT NULL, couleur_side VARCHAR(255) NOT NULL, active INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE partenaire (id INT AUTO_INCREMENT NOT NULL, libelle VARCHAR(255) NOT NULL, logo VARCHAR(255) NOT NULL, active INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE post (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(255) NOT NULL, image VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE produit (id INT AUTO_INCREMENT NOT NULL, categorie_id INT DEFAULT NULL, libelle VARCHAR(255) NOT NULL, date_ajout DATE NOT NULL, description LONGTEXT NOT NULL, active INT NOT NULL, INDEX IDX_29A5EC27BCF5E72D (categorie_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE profession (id INT AUTO_INCREMENT NOT NULL, libelle VARCHAR(255) NOT NULL, active INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE status (id INT AUTO_INCREMENT NOT NULL, libelle VARCHAR(255) NOT NULL, active INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE type_acte (id INT AUTO_INCREMENT NOT NULL, titre VARCHAR(255) NOT NULL, active VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles LONGTEXT NOT NULL COMMENT \'(DC2Type:json)\', password VARCHAR(255) NOT NULL, nom VARCHAR(255) NOT NULL, prenoms VARCHAR(255) NOT NULL, active INT NOT NULL, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE acte ADD CONSTRAINT FK_9EC41326858C065E FOREIGN KEY (vendeur_id) REFERENCES client (id)');
        $this->addSql('ALTER TABLE acte ADD CONSTRAINT FK_9EC4132696A7BB5F FOREIGN KEY (acheteur_id) REFERENCES client (id)');
        $this->addSql('ALTER TABLE acte ADD CONSTRAINT FK_9EC41326C54C8C93 FOREIGN KEY (type_id) REFERENCES type_acte (id)');
        $this->addSql('ALTER TABLE calendar ADD CONSTRAINT FK_6EA9A14619EB6921 FOREIGN KEY (client_id) REFERENCES client (id)');
        $this->addSql('ALTER TABLE courier_arrive ADD CONSTRAINT FK_90FA9925A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE courier_arrive ADD CONSTRAINT FK_90FA9925D26628FA FOREIGN KEY (exp_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE courier_arrive ADD CONSTRAINT FK_90FA992510335F61 FOREIGN KEY (expediteur_id) REFERENCES client (id)');
        $this->addSql('ALTER TABLE courier_arrive ADD CONSTRAINT FK_90FA99257F5413B1 FOREIGN KEY (recep_id) REFERENCES client (id)');
        $this->addSql('ALTER TABLE departement ADD CONSTRAINT FK_C1765B6398260155 FOREIGN KEY (region_id) REFERENCES localite (id)');
        $this->addSql('ALTER TABLE fichier ADD CONSTRAINT FK_9B76551FF4028648 FOREIGN KEY (arrive_id) REFERENCES courier_arrive (id)');
        $this->addSql('ALTER TABLE fichier_acte ADD CONSTRAINT FK_1F4BDBCDA767B8C7 FOREIGN KEY (acte_id) REFERENCES acte (id)');
        $this->addSql('ALTER TABLE groupe ADD CONSTRAINT FK_4B98C21AFC2B591 FOREIGN KEY (module_id) REFERENCES module (id)');
        $this->addSql('ALTER TABLE groupe ADD CONSTRAINT FK_4B98C2154B9D732 FOREIGN KEY (icon_id) REFERENCES icons (id)');
        $this->addSql('ALTER TABLE image ADD CONSTRAINT FK_C53D045FF347EFB FOREIGN KEY (produit_id) REFERENCES produit (id)');
        $this->addSql('ALTER TABLE images ADD CONSTRAINT FK_E01FBE6A9B177F54 FOREIGN KEY (chambre_id) REFERENCES chambre (id)');
        $this->addSql('ALTER TABLE membre ADD CONSTRAINT FK_F6B4FB2998260155 FOREIGN KEY (region_id) REFERENCES localite (id)');
        $this->addSql('ALTER TABLE membre ADD CONSTRAINT FK_F6B4FB29FDEF8996 FOREIGN KEY (profession_id) REFERENCES profession (id)');
        $this->addSql('ALTER TABLE membre ADD CONSTRAINT FK_F6B4FB29CCF9E01E FOREIGN KEY (departement_id) REFERENCES departement (id)');
        $this->addSql('ALTER TABLE module ADD CONSTRAINT FK_C242628727ACA70 FOREIGN KEY (parent_id) REFERENCES module_parent (id)');
        $this->addSql('ALTER TABLE module ADD CONSTRAINT FK_C24262854B9D732 FOREIGN KEY (icon_id) REFERENCES icons (id)');
        $this->addSql('ALTER TABLE produit ADD CONSTRAINT FK_29A5EC27BCF5E72D FOREIGN KEY (categorie_id) REFERENCES categorie (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE fichier_acte DROP FOREIGN KEY FK_1F4BDBCDA767B8C7');
        $this->addSql('ALTER TABLE produit DROP FOREIGN KEY FK_29A5EC27BCF5E72D');
        $this->addSql('ALTER TABLE images DROP FOREIGN KEY FK_E01FBE6A9B177F54');
        $this->addSql('ALTER TABLE acte DROP FOREIGN KEY FK_9EC41326858C065E');
        $this->addSql('ALTER TABLE acte DROP FOREIGN KEY FK_9EC4132696A7BB5F');
        $this->addSql('ALTER TABLE calendar DROP FOREIGN KEY FK_6EA9A14619EB6921');
        $this->addSql('ALTER TABLE courier_arrive DROP FOREIGN KEY FK_90FA992510335F61');
        $this->addSql('ALTER TABLE courier_arrive DROP FOREIGN KEY FK_90FA99257F5413B1');
        $this->addSql('ALTER TABLE fichier DROP FOREIGN KEY FK_9B76551FF4028648');
        $this->addSql('ALTER TABLE membre DROP FOREIGN KEY FK_F6B4FB29CCF9E01E');
        $this->addSql('ALTER TABLE groupe DROP FOREIGN KEY FK_4B98C2154B9D732');
        $this->addSql('ALTER TABLE module DROP FOREIGN KEY FK_C24262854B9D732');
        $this->addSql('ALTER TABLE departement DROP FOREIGN KEY FK_C1765B6398260155');
        $this->addSql('ALTER TABLE membre DROP FOREIGN KEY FK_F6B4FB2998260155');
        $this->addSql('ALTER TABLE groupe DROP FOREIGN KEY FK_4B98C21AFC2B591');
        $this->addSql('ALTER TABLE module DROP FOREIGN KEY FK_C242628727ACA70');
        $this->addSql('ALTER TABLE image DROP FOREIGN KEY FK_C53D045FF347EFB');
        $this->addSql('ALTER TABLE membre DROP FOREIGN KEY FK_F6B4FB29FDEF8996');
        $this->addSql('ALTER TABLE acte DROP FOREIGN KEY FK_9EC41326C54C8C93');
        $this->addSql('ALTER TABLE courier_arrive DROP FOREIGN KEY FK_90FA9925A76ED395');
        $this->addSql('ALTER TABLE courier_arrive DROP FOREIGN KEY FK_90FA9925D26628FA');
        $this->addSql('DROP TABLE acte');
        $this->addSql('DROP TABLE calendar');
        $this->addSql('DROP TABLE categorie');
        $this->addSql('DROP TABLE chambre');
        $this->addSql('DROP TABLE client');
        $this->addSql('DROP TABLE contact');
        $this->addSql('DROP TABLE courier_arrive');
        $this->addSql('DROP TABLE departement');
        $this->addSql('DROP TABLE fichier');
        $this->addSql('DROP TABLE fichier_acte');
        $this->addSql('DROP TABLE groupe');
        $this->addSql('DROP TABLE icons');
        $this->addSql('DROP TABLE image');
        $this->addSql('DROP TABLE images');
        $this->addSql('DROP TABLE localite');
        $this->addSql('DROP TABLE marque');
        $this->addSql('DROP TABLE membre');
        $this->addSql('DROP TABLE module');
        $this->addSql('DROP TABLE module_parent');
        $this->addSql('DROP TABLE parametre');
        $this->addSql('DROP TABLE partenaire');
        $this->addSql('DROP TABLE post');
        $this->addSql('DROP TABLE produit');
        $this->addSql('DROP TABLE profession');
        $this->addSql('DROP TABLE status');
        $this->addSql('DROP TABLE type_acte');
        $this->addSql('DROP TABLE user');
    }
}
