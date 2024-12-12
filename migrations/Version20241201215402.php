<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241201215402 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE `admin` (id_user INT NOT NULL, post_admin VARCHAR(255) NOT NULL, PRIMARY KEY(id_user)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE category (idCategory INT AUTO_INCREMENT NOT NULL, nomCategory VARCHAR(255) NOT NULL, PRIMARY KEY(idCategory)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE chatbot (id_chatbot INT AUTO_INCREMENT NOT NULL, datecreation_chatbot DATETIME NOT NULL, contenu_chatbot LONGTEXT NOT NULL, autheur_chatbot INT NOT NULL, PRIMARY KEY(id_chatbot)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE cours (Id_Cours INT AUTO_INCREMENT NOT NULL, titre_cours VARCHAR(255) NOT NULL, descriptio_cours LONGTEXT NOT NULL, id_enseignant_cours INT NOT NULL, date_creation_cours DATETIME NOT NULL, PRIMARY KEY(Id_Cours)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE enseignant (id_user INT NOT NULL, spécialite_enseignant VARCHAR(255) NOT NULL, departement_enseignant VARCHAR(255) NOT NULL, etat_enseignant VARCHAR(255) NOT NULL, PRIMARY KEY(id_user)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE etudiant (id_user INT NOT NULL, specialité_etudiant VARCHAR(255) NOT NULL, niveau_etudiant VARCHAR(255) NOT NULL, classe_etudiant VARCHAR(255) NOT NULL, PRIMARY KEY(id_user)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE evenement (idEvenement INT AUTO_INCREMENT NOT NULL, titre_evenement VARCHAR(255) NOT NULL, date_evenement DATETIME NOT NULL, description_evenement LONGTEXT NOT NULL, organisateur_evenement VARCHAR(255) NOT NULL, lien_evenement VARCHAR(255) NOT NULL, lieu_evenement VARCHAR(255) NOT NULL, idCategory INT NOT NULL, INDEX IDX_B26681E55EF339A (idCategory), PRIMARY KEY(idEvenement)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE forum (id_forum INT AUTO_INCREMENT NOT NULL, titre_forum VARCHAR(255) NOT NULL, description_forum LONGTEXT NOT NULL, createur_forum VARCHAR(255) NOT NULL, PRIMARY KEY(id_forum)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE message_forum (id_message_forum INT AUTO_INCREMENT NOT NULL, createur_message_forum VARCHAR(255) NOT NULL, id_forum INT NOT NULL, conetenu_id_message_forum LONGTEXT NOT NULL, date_creation_id_message_forum DATETIME NOT NULL, PRIMARY KEY(id_message_forum)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE reclamation (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(255) NOT NULL, description LONGTEXT NOT NULL, created_at DATETIME NOT NULL, status VARCHAR(50) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE ressource (id_ressource INT AUTO_INCREMENT NOT NULL, titre_ressource VARCHAR(255) NOT NULL, description_ressource VARCHAR(800) NOT NULL, type_ressource VARCHAR(255) NOT NULL, id_enseignat_ressource INT NOT NULL, url_ressource VARCHAR(255) NOT NULL, date_creation_ressource DATETIME NOT NULL, Id_Cours INT NOT NULL, INDEX IDX_939F45442BF880FE (Id_Cours), PRIMARY KEY(id_ressource)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id_user INT AUTO_INCREMENT NOT NULL, nom_user VARCHAR(255) NOT NULL, prenom_user VARCHAR(255) NOT NULL, email_user VARCHAR(255) DEFAULT NULL, motdepasse_user VARCHAR(255) NOT NULL, numtelephone_user INT NOT NULL, role_user VARCHAR(255) NOT NULL, datenaissance_user DATE NOT NULL, photo_user VARCHAR(255) DEFAULT NULL, discr VARCHAR(255) NOT NULL, PRIMARY KEY(id_user)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', available_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', delivered_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE `admin` ADD CONSTRAINT FK_880E0D766B3CA4B FOREIGN KEY (id_user) REFERENCES user (id_user) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE enseignant ADD CONSTRAINT FK_81A72FA16B3CA4B FOREIGN KEY (id_user) REFERENCES user (id_user) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE etudiant ADD CONSTRAINT FK_717E22E36B3CA4B FOREIGN KEY (id_user) REFERENCES user (id_user) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE evenement ADD CONSTRAINT FK_B26681E55EF339A FOREIGN KEY (idCategory) REFERENCES category (idCategory)');
        $this->addSql('ALTER TABLE ressource ADD CONSTRAINT FK_939F45442BF880FE FOREIGN KEY (Id_Cours) REFERENCES cours (Id_Cours)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE `admin` DROP FOREIGN KEY FK_880E0D766B3CA4B');
        $this->addSql('ALTER TABLE enseignant DROP FOREIGN KEY FK_81A72FA16B3CA4B');
        $this->addSql('ALTER TABLE etudiant DROP FOREIGN KEY FK_717E22E36B3CA4B');
        $this->addSql('ALTER TABLE evenement DROP FOREIGN KEY FK_B26681E55EF339A');
        $this->addSql('ALTER TABLE ressource DROP FOREIGN KEY FK_939F45442BF880FE');
        $this->addSql('DROP TABLE `admin`');
        $this->addSql('DROP TABLE category');
        $this->addSql('DROP TABLE chatbot');
        $this->addSql('DROP TABLE cours');
        $this->addSql('DROP TABLE enseignant');
        $this->addSql('DROP TABLE etudiant');
        $this->addSql('DROP TABLE evenement');
        $this->addSql('DROP TABLE forum');
        $this->addSql('DROP TABLE message_forum');
        $this->addSql('DROP TABLE reclamation');
        $this->addSql('DROP TABLE ressource');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
