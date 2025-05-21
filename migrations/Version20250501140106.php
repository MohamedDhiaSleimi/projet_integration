<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250501140106 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            CREATE TABLE cv (id INT AUTO_INCREMENT NOT NULL, student_id INT NOT NULL, title VARCHAR(255) NOT NULL, description LONGTEXT NOT NULL, skills VARCHAR(255) NOT NULL, education VARCHAR(255) NOT NULL, experience VARCHAR(255) DEFAULT NULL, languages VARCHAR(255) DEFAULT NULL, UNIQUE INDEX UNIQ_B66FFE92CB944F1A (student_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE cv ADD CONSTRAINT FK_B66FFE92CB944F1A FOREIGN KEY (student_id) REFERENCES user (id)
        SQL);
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            ALTER TABLE cv DROP FOREIGN KEY FK_B66FFE92CB944F1A
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE cv
        SQL);
    }
}
