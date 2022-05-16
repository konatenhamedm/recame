<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220515074840 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE courier_depart');
        $this->addSql('DROP TABLE courier_interne');
        $this->addSql('ALTER TABLE courier_arrive ADD exp_id INT DEFAULT NULL, ADD expediteur_id INT DEFAULT NULL, ADD recep_id INT DEFAULT NULL, ADD etat TINYINT(1) DEFAULT NULL, ADD type VARCHAR(255) NOT NULL, ADD existe TINYINT(1) DEFAULT NULL, DROP expediteur, DROP destinataire');
        $this->addSql('ALTER TABLE courier_arrive ADD CONSTRAINT FK_90FA9925D26628FA FOREIGN KEY (exp_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE courier_arrive ADD CONSTRAINT FK_90FA992510335F61 FOREIGN KEY (expediteur_id) REFERENCES client (id)');
        $this->addSql('ALTER TABLE courier_arrive ADD CONSTRAINT FK_90FA99257F5413B1 FOREIGN KEY (recep_id) REFERENCES client (id)');
        $this->addSql('CREATE INDEX IDX_90FA9925D26628FA ON courier_arrive (exp_id)');
        $this->addSql('CREATE INDEX IDX_90FA992510335F61 ON courier_arrive (expediteur_id)');
        $this->addSql('CREATE INDEX IDX_90FA99257F5413B1 ON courier_arrive (recep_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE courier_depart (id INT AUTO_INCREMENT NOT NULL, numero VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, date_depart DATETIME NOT NULL, objet VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, categorie VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, expediteur VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, destinataire VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, etat TINYINT(1) NOT NULL, date_reception DATETIME NOT NULL, active VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE courier_interne (id INT AUTO_INCREMENT NOT NULL, numero VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, date_envoi DATETIME NOT NULL, objet VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, categorie VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, expediteur VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, destinataire VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, etat TINYINT(1) NOT NULL, date_reception DATETIME NOT NULL, active VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE courier_arrive DROP FOREIGN KEY FK_90FA9925D26628FA');
        $this->addSql('ALTER TABLE courier_arrive DROP FOREIGN KEY FK_90FA992510335F61');
        $this->addSql('ALTER TABLE courier_arrive DROP FOREIGN KEY FK_90FA99257F5413B1');
        $this->addSql('DROP INDEX IDX_90FA9925D26628FA ON courier_arrive');
        $this->addSql('DROP INDEX IDX_90FA992510335F61 ON courier_arrive');
        $this->addSql('DROP INDEX IDX_90FA99257F5413B1 ON courier_arrive');
        $this->addSql('ALTER TABLE courier_arrive ADD destinataire VARCHAR(255) NOT NULL, DROP exp_id, DROP expediteur_id, DROP recep_id, DROP etat, DROP existe, CHANGE type expediteur VARCHAR(255) NOT NULL');
    }
}
