<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241206171206 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
   
        $this->addSql('ALTER TABLE message_forum CHANGE id_forum id_forum INT DEFAULT NULL');
        $this->addSql('ALTER TABLE message_forum RENAME INDEX id_forum TO IDX_7A8D41266BAEFFFD');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        
        $this->addSql('ALTER TABLE message_forum DROP FOREIGN KEY FK_7A8D412673B893E1');
        $this->addSql('ALTER TABLE message_forum DROP FOREIGN KEY FK_7A8D41266BAEFFFD');
        $this->addSql('ALTER TABLE message_forum CHANGE id_forum id_forum INT NOT NULL');
        $this->addSql('ALTER TABLE message_forum RENAME INDEX idx_7a8d41266baefffd TO id_forum');
    }
}
