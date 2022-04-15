<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220415210643 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE departement DROP FOREIGN KEY FK_C1765B6387C027E4');
        $this->addSql('DROP TABLE code_departement');
        $this->addSql('DROP INDEX IDX_C1765B6387C027E4 ON departement');
        $this->addSql('ALTER TABLE departement DROP code_departement_id, DROP abrege_departement, DROP couleur_departement, DROP etat');
        $this->addSql('ALTER TABLE marque ADD active INT DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE code_departement (id INT AUTO_INCREMENT NOT NULL, libelle VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, active VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE departement ADD code_departement_id INT DEFAULT NULL, ADD abrege_departement VARCHAR(255) NOT NULL, ADD couleur_departement VARCHAR(255) NOT NULL, ADD etat INT NOT NULL');
        $this->addSql('ALTER TABLE departement ADD CONSTRAINT FK_C1765B6387C027E4 FOREIGN KEY (code_departement_id) REFERENCES code_departement (id)');
        $this->addSql('CREATE INDEX IDX_C1765B6387C027E4 ON departement (code_departement_id)');
        $this->addSql('ALTER TABLE marque DROP active');
    }
}
