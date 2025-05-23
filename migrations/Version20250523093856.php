<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250523093856 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            ALTER TABLE cv DROP INDEX IDX_B66FFE92CB944F1A, ADD UNIQUE INDEX UNIQ_B66FFE92CB944F1A (student_id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE cv ADD filename VARCHAR(255) NOT NULL, DROP title, DROP description, DROP skills, DROP education, DROP experience, DROP languages
        SQL);
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            ALTER TABLE cv DROP INDEX UNIQ_B66FFE92CB944F1A, ADD INDEX IDX_B66FFE92CB944F1A (student_id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE cv ADD description LONGTEXT NOT NULL, ADD skills VARCHAR(255) NOT NULL, ADD education VARCHAR(255) NOT NULL, ADD experience VARCHAR(255) DEFAULT NULL, ADD languages VARCHAR(255) DEFAULT NULL, CHANGE filename title VARCHAR(255) NOT NULL
        SQL);
    }
}
