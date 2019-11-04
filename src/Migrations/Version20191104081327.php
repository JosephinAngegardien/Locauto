<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20191104081327 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE voiture_categorie (voiture_id INT NOT NULL, categorie_id INT NOT NULL, INDEX IDX_D309F970181A8BA (voiture_id), INDEX IDX_D309F970BCF5E72D (categorie_id), PRIMARY KEY(voiture_id, categorie_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE categorie (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE voiture_categorie ADD CONSTRAINT FK_D309F970181A8BA FOREIGN KEY (voiture_id) REFERENCES voiture (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE voiture_categorie ADD CONSTRAINT FK_D309F970BCF5E72D FOREIGN KEY (categorie_id) REFERENCES categorie (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE particulier DROP adresse, DROP codepostal, DROP ville');
        $this->addSql('ALTER TABLE professionnel DROP adresse, DROP codepostal, DROP ville');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE voiture_categorie DROP FOREIGN KEY FK_D309F970BCF5E72D');
        $this->addSql('DROP TABLE voiture_categorie');
        $this->addSql('DROP TABLE categorie');
        $this->addSql('ALTER TABLE particulier ADD adresse VARCHAR(255) NOT NULL COLLATE utf8mb4_unicode_ci, ADD codepostal VARCHAR(255) NOT NULL COLLATE utf8mb4_unicode_ci, ADD ville VARCHAR(255) NOT NULL COLLATE utf8mb4_unicode_ci');
        $this->addSql('ALTER TABLE professionnel ADD adresse VARCHAR(255) NOT NULL COLLATE utf8mb4_unicode_ci, ADD codepostal VARCHAR(255) NOT NULL COLLATE utf8mb4_unicode_ci, ADD ville VARCHAR(255) NOT NULL COLLATE utf8mb4_unicode_ci');
    }
}
