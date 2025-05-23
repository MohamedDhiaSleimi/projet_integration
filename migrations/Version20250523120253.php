<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250523120253 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            ALTER TABLE application ADD CONSTRAINT FK_A45BDDC119E9AC5F FOREIGN KEY (supervisor_id) REFERENCES user (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE user ADD department VARCHAR(255) DEFAULT NULL, ADD phone_number VARCHAR(255) DEFAULT NULL
        SQL);
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            ALTER TABLE application DROP FOREIGN KEY FK_A45BDDC119E9AC5F
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE user DROP department, DROP phone_number
        SQL);
    }
}
