<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250523135456 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            CREATE TABLE seance_encadrement (id INT AUTO_INCREMENT NOT NULL, student_id INT NOT NULL, supervisor_id INT NOT NULL, date DATETIME NOT NULL, commentaire LONGTEXT NOT NULL, INDEX IDX_82D08042CB944F1A (student_id), INDEX IDX_82D0804219E9AC5F (supervisor_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE seance_encadrement ADD CONSTRAINT FK_82D08042CB944F1A FOREIGN KEY (student_id) REFERENCES user (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE seance_encadrement ADD CONSTRAINT FK_82D0804219E9AC5F FOREIGN KEY (supervisor_id) REFERENCES user (id)
        SQL);
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            ALTER TABLE seance_encadrement DROP FOREIGN KEY FK_82D08042CB944F1A
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE seance_encadrement DROP FOREIGN KEY FK_82D0804219E9AC5F
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE seance_encadrement
        SQL);
    }
}
