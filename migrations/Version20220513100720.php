<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220513100720 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE courier_depart (id INT AUTO_INCREMENT NOT NULL, numero VARCHAR(255) NOT NULL, date_depart DATETIME NOT NULL, objet VARCHAR(255) NOT NULL, categorie VARCHAR(255) NOT NULL, expediteur VARCHAR(255) NOT NULL, destinataire VARCHAR(255) NOT NULL, etat TINYINT(1) NOT NULL, date_reception DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE courier_interne (id INT AUTO_INCREMENT NOT NULL, numero VARCHAR(255) NOT NULL, date_envoi DATETIME NOT NULL, objet VARCHAR(255) NOT NULL, categorie VARCHAR(255) NOT NULL, expediteur VARCHAR(255) NOT NULL, destinataire VARCHAR(255) NOT NULL, etat TINYINT(1) NOT NULL, date_reception DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE fichier (id INT AUTO_INCREMENT NOT NULL, arrive_id INT DEFAULT NULL, depart_id INT DEFAULT NULL, path VARCHAR(255) NOT NULL, INDEX IDX_9B76551FF4028648 (arrive_id), INDEX IDX_9B76551FAE02FE4B (depart_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE fichier ADD CONSTRAINT FK_9B76551FF4028648 FOREIGN KEY (arrive_id) REFERENCES courier_arrive (id)');
        $this->addSql('ALTER TABLE fichier ADD CONSTRAINT FK_9B76551FAE02FE4B FOREIGN KEY (depart_id) REFERENCES courier_depart (id)');
        $this->addSql('ALTER TABLE courier_arrive ADD user_id INT DEFAULT NULL, ADD numero VARCHAR(255) NOT NULL, ADD date_reception DATETIME NOT NULL, ADD objet LONGTEXT NOT NULL, ADD expediteur VARCHAR(255) NOT NULL, ADD destinataire VARCHAR(255) NOT NULL, ADD categorie VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE courier_arrive ADD CONSTRAINT FK_90FA9925A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_90FA9925A76ED395 ON courier_arrive (user_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE fichier DROP FOREIGN KEY FK_9B76551FAE02FE4B');
        $this->addSql('DROP TABLE courier_depart');
        $this->addSql('DROP TABLE courier_interne');
        $this->addSql('DROP TABLE fichier');
        $this->addSql('ALTER TABLE courier_arrive DROP FOREIGN KEY FK_90FA9925A76ED395');
        $this->addSql('DROP INDEX IDX_90FA9925A76ED395 ON courier_arrive');
        $this->addSql('ALTER TABLE courier_arrive DROP user_id, DROP numero, DROP date_reception, DROP objet, DROP expediteur, DROP destinataire, DROP categorie');
    }
}
