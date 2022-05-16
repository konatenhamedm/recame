<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220515233601 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE acte (id INT AUTO_INCREMENT NOT NULL, vendeur_id INT DEFAULT NULL, acheteur_id INT DEFAULT NULL, type_id INT DEFAULT NULL, fichier_id INT DEFAULT NULL, date DATETIME DEFAULT NULL, objet VARCHAR(255) NOT NULL, montant DOUBLE PRECISION NOT NULL, INDEX IDX_9EC41326858C065E (vendeur_id), INDEX IDX_9EC4132696A7BB5F (acheteur_id), INDEX IDX_9EC41326C54C8C93 (type_id), INDEX IDX_9EC41326F915CFE (fichier_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE fichier_acte (id INT AUTO_INCREMENT NOT NULL, titre VARCHAR(255) NOT NULL, path VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE type_acte (id INT AUTO_INCREMENT NOT NULL, titre VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE acte ADD CONSTRAINT FK_9EC41326858C065E FOREIGN KEY (vendeur_id) REFERENCES client (id)');
        $this->addSql('ALTER TABLE acte ADD CONSTRAINT FK_9EC4132696A7BB5F FOREIGN KEY (acheteur_id) REFERENCES client (id)');
        $this->addSql('ALTER TABLE acte ADD CONSTRAINT FK_9EC41326C54C8C93 FOREIGN KEY (type_id) REFERENCES type_acte (id)');
        $this->addSql('ALTER TABLE acte ADD CONSTRAINT FK_9EC41326F915CFE FOREIGN KEY (fichier_id) REFERENCES fichier_acte (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE acte DROP FOREIGN KEY FK_9EC41326F915CFE');
        $this->addSql('ALTER TABLE acte DROP FOREIGN KEY FK_9EC41326C54C8C93');
        $this->addSql('DROP TABLE acte');
        $this->addSql('DROP TABLE fichier_acte');
        $this->addSql('DROP TABLE type_acte');
    }
}
