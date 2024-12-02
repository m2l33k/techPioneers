<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241129081524 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE forum CHANGE createur_forum createur_forum INT DEFAULT NULL');
        $this->addSql('ALTER TABLE forum ADD CONSTRAINT FK_852BBECD12C40417 FOREIGN KEY (createur_forum) REFERENCES user (id_user)');
        $this->addSql('CREATE INDEX IDX_852BBECD12C40417 ON forum (createur_forum)');
        $this->addSql('ALTER TABLE message_forum CHANGE id_forum id_forum INT DEFAULT NULL');
        $this->addSql('ALTER TABLE message_forum ADD CONSTRAINT FK_7A8D41266BAEFFFD FOREIGN KEY (id_forum) REFERENCES forum (id_forum)');
        $this->addSql('CREATE INDEX IDX_7A8D41266BAEFFFD ON message_forum (id_forum)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE message_forum DROP FOREIGN KEY FK_7A8D41266BAEFFFD');
        $this->addSql('DROP INDEX IDX_7A8D41266BAEFFFD ON message_forum');
        $this->addSql('ALTER TABLE message_forum CHANGE id_forum id_forum INT NOT NULL');
        $this->addSql('ALTER TABLE forum DROP FOREIGN KEY FK_852BBECD12C40417');
        $this->addSql('DROP INDEX IDX_852BBECD12C40417 ON forum');
        $this->addSql('ALTER TABLE forum CHANGE createur_forum createur_forum VARCHAR(255) NOT NULL');
    }
}
