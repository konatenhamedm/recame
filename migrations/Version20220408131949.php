<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220408131949 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE code_departement DROP ordre');
        $this->addSql('ALTER TABLE departement DROP ordre, CHANGE active active INT NOT NULL');
        $this->addSql('ALTER TABLE localite DROP ordre, CHANGE active active INT NOT NULL');
        $this->addSql('ALTER TABLE membre DROP ordre, CHANGE active active INT NOT NULL');
        $this->addSql('ALTER TABLE profession DROP ordre, CHANGE active active INT NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE code_departement ADD ordre INT NOT NULL');
        $this->addSql('ALTER TABLE departement ADD ordre INT NOT NULL, CHANGE active active VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE localite ADD ordre INT NOT NULL, CHANGE active active VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE membre ADD ordre INT NOT NULL, CHANGE active active VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE profession ADD ordre INT NOT NULL, CHANGE active active VARCHAR(255) NOT NULL');
    }
}
