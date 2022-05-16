<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220516011046 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE fichier_acte ADD acte_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE fichier_acte ADD CONSTRAINT FK_1F4BDBCDA767B8C7 FOREIGN KEY (acte_id) REFERENCES acte (id)');
        $this->addSql('CREATE INDEX IDX_1F4BDBCDA767B8C7 ON fichier_acte (acte_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE fichier_acte DROP FOREIGN KEY FK_1F4BDBCDA767B8C7');
        $this->addSql('DROP INDEX IDX_1F4BDBCDA767B8C7 ON fichier_acte');
        $this->addSql('ALTER TABLE fichier_acte DROP acte_id');
    }
}
