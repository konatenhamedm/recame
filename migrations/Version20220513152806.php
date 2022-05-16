<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220513152806 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE client ADD active VARCHAR(255) NOT NULL, ADD photo VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE courier_arrive ADD active VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE courier_depart ADD active VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE courier_interne ADD active VARCHAR(255) NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE client DROP active, DROP photo');
        $this->addSql('ALTER TABLE courier_arrive DROP active');
        $this->addSql('ALTER TABLE courier_depart DROP active');
        $this->addSql('ALTER TABLE courier_interne DROP active');
    }
}
