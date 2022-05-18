<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220516151620 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE client CHANGE profession profession VARCHAR(255) DEFAULT NULL, CHANGE domicile domicile VARCHAR(255) DEFAULT NULL, CHANGE pere pere VARCHAR(255) DEFAULT NULL, CHANGE mere mere VARCHAR(255) DEFAULT NULL, CHANGE etat_bien_vendu etat_bien_vendu VARCHAR(255) DEFAULT NULL, CHANGE adresse adresse VARCHAR(255) DEFAULT NULL, CHANGE tel_domicile tel_domicile VARCHAR(255) DEFAULT NULL, CHANGE tel_bureau tel_bureau VARCHAR(255) DEFAULT NULL, CHANGE email email VARCHAR(255) DEFAULT NULL, CHANGE nationalite nationalite VARCHAR(255) DEFAULT NULL, CHANGE situation situation VARCHAR(255) DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE client CHANGE profession profession VARCHAR(255) NOT NULL, CHANGE domicile domicile VARCHAR(255) NOT NULL, CHANGE pere pere VARCHAR(255) NOT NULL, CHANGE mere mere VARCHAR(255) NOT NULL, CHANGE etat_bien_vendu etat_bien_vendu VARCHAR(255) NOT NULL, CHANGE adresse adresse VARCHAR(255) NOT NULL, CHANGE tel_domicile tel_domicile VARCHAR(255) NOT NULL, CHANGE tel_bureau tel_bureau VARCHAR(255) NOT NULL, CHANGE email email VARCHAR(255) NOT NULL, CHANGE nationalite nationalite VARCHAR(255) NOT NULL, CHANGE situation situation VARCHAR(255) NOT NULL');
    }
}
