<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220513230435 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE fichier DROP FOREIGN KEY FK_9B76551FAE02FE4B');
        $this->addSql('DROP INDEX IDX_9B76551FAE02FE4B ON fichier');
        $this->addSql('ALTER TABLE fichier DROP depart_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE fichier ADD depart_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE fichier ADD CONSTRAINT FK_9B76551FAE02FE4B FOREIGN KEY (depart_id) REFERENCES courier_depart (id)');
        $this->addSql('CREATE INDEX IDX_9B76551FAE02FE4B ON fichier (depart_id)');
    }
}
