<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241128082717 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
       
        $this->addSql('CREATE TABLE forum (id_forum INT AUTO_INCREMENT NOT NULL, titre_forum VARCHAR(255) NOT NULL, description_forum LONGTEXT NOT NULL, createur_forum VARCHAR(255) NOT NULL, PRIMARY KEY(id_forum)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE message_forum (id_message_forum INT AUTO_INCREMENT NOT NULL, createur_message_forum VARCHAR(255) NOT NULL, id_forum INT NOT NULL, conetenu_id_message_forum LONGTEXT NOT NULL, date_creation_id_message_forum DATETIME NOT NULL, PRIMARY KEY(id_message_forum)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
       
    }

    public function down(Schema $schema): void
    {
       
        $this->addSql('DROP TABLE forum');
        $this->addSql('DROP TABLE message_forum');
      
    }
}
