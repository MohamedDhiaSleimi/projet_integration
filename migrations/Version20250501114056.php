<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250501114056 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE supervisor (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, departement VARCHAR(255) DEFAULT NULL, phone_number VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE application ADD supervisor_id INT DEFAULT NULL, ADD start_date DATE DEFAULT NULL, ADD end_date DATE DEFAULT NULL');
        $this->addSql('ALTER TABLE application ADD CONSTRAINT FK_A45BDDC119E9AC5F FOREIGN KEY (supervisor_id) REFERENCES supervisor (id)');
        $this->addSql('CREATE INDEX IDX_A45BDDC119E9AC5F ON application (supervisor_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE application DROP FOREIGN KEY FK_A45BDDC119E9AC5F');
        $this->addSql('DROP TABLE supervisor');
        $this->addSql('DROP INDEX IDX_A45BDDC119E9AC5F ON application');
        $this->addSql('ALTER TABLE application DROP supervisor_id, DROP start_date, DROP end_date');
    }
}
