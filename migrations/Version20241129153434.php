<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241129153434 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        
        $this->addSql('ALTER TABLE message_forum ADD CreateurMessageForum INT DEFAULT NULL, DROP createur_message_forum');
        $this->addSql('ALTER TABLE message_forum ADD CONSTRAINT FK_7A8D412673B893E1 FOREIGN KEY (CreateurMessageForum) REFERENCES user (idUser)');
        $this->addSql('CREATE INDEX IDX_7A8D412673B893E1 ON message_forum (CreateurMessageForum)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
    
        $this->addSql('ALTER TABLE message_forum DROP FOREIGN KEY FK_7A8D412673B893E1');
        $this->addSql('DROP INDEX IDX_7A8D412673B893E1 ON message_forum');
        $this->addSql('ALTER TABLE message_forum ADD createur_message_forum VARCHAR(255) NOT NULL, DROP CreateurMessageForum');
    }
}
