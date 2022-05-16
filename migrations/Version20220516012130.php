<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220516012130 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE type_acte DROP FOREIGN KEY FK_49CBD62EA767B8C7');
        $this->addSql('DROP INDEX IDX_49CBD62EA767B8C7 ON type_acte');
        $this->addSql('ALTER TABLE type_acte DROP acte_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE type_acte ADD acte_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE type_acte ADD CONSTRAINT FK_49CBD62EA767B8C7 FOREIGN KEY (acte_id) REFERENCES acte (id)');
        $this->addSql('CREATE INDEX IDX_49CBD62EA767B8C7 ON type_acte (acte_id)');
    }
}
