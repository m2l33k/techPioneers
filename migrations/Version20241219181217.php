<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241219181217 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE category (idCategory INT AUTO_INCREMENT NOT NULL, nomCategory VARCHAR(255) NOT NULL, PRIMARY KEY(idCategory)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE chatbot (id_chatbot INT AUTO_INCREMENT NOT NULL, datecreation_chatbot DATETIME NOT NULL, contenu_chatbot LONGTEXT NOT NULL, autheur_chatbot INT NOT NULL, PRIMARY KEY(id_chatbot)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE cours (id_enseignant_cours_id INT DEFAULT NULL, Id_Cours INT AUTO_INCREMENT NOT NULL, titre_cours VARCHAR(255) NOT NULL, descriptio_cours LONGTEXT NOT NULL, date_creation_cours DATETIME NOT NULL, INDEX IDX_FDCA8C9C928C6DD3 (id_enseignant_cours_id), PRIMARY KEY(Id_Cours)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE enseignant (id INT NOT NULL, spécialite_enseignant VARCHAR(255) NOT NULL, departement_enseignant VARCHAR(255) NOT NULL, etat_enseignant VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE etudiant (id_etudiant INT NOT NULL, specialité_etudiant VARCHAR(255) NOT NULL, niveau_etudiant VARCHAR(255) NOT NULL, classe_etudiant VARCHAR(255) NOT NULL, PRIMARY KEY(id_etudiant)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE evenement (id INT AUTO_INCREMENT NOT NULL, category_id INT DEFAULT NULL, event_name VARCHAR(50) NOT NULL, event_date DATE DEFAULT NULL, event_desc VARCHAR(255) NOT NULL, type_evenement VARCHAR(255) DEFAULT NULL, nb_projet INT DEFAULT NULL, capacite INT DEFAULT NULL, image VARCHAR(255) DEFAULT NULL, status TINYINT(1) NOT NULL, event_place VARCHAR(50) NOT NULL, INDEX IDX_B26681E12469DE2 (category_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE forum (id_forum INT AUTO_INCREMENT NOT NULL, createur_forum INT DEFAULT NULL, titre_forum VARCHAR(255) NOT NULL, description_forum LONGTEXT NOT NULL, created_at DATETIME NOT NULL, INDEX IDX_852BBECD12C40417 (createur_forum), PRIMARY KEY(id_forum)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE message_forum (id_message_forum INT AUTO_INCREMENT NOT NULL, id_forum INT DEFAULT NULL, conetenu_id_message_forum LONGTEXT NOT NULL, date_creation_id_message_forum DATETIME NOT NULL, CreateurMessageForum INT DEFAULT NULL, INDEX IDX_7A8D412673B893E1 (CreateurMessageForum), INDEX IDX_7A8D41266BAEFFFD (id_forum), PRIMARY KEY(id_message_forum)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE projet (id INT AUTO_INCREMENT NOT NULL, evenement_id INT NOT NULL, title VARCHAR(50) NOT NULL, projetdesc VARCHAR(255) DEFAULT NULL, fichier VARCHAR(255) DEFAULT NULL, INDEX IDX_50159CA9FD02F13 (evenement_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE reclamation (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(255) NOT NULL, description LONGTEXT NOT NULL, created_at DATETIME NOT NULL, status VARCHAR(50) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE ressource (id_ressource INT AUTO_INCREMENT NOT NULL, titre_ressource VARCHAR(255) NOT NULL, description_ressource VARCHAR(800) NOT NULL, type_ressource VARCHAR(255) NOT NULL, id_enseignat_ressource INT NOT NULL, url_ressource VARCHAR(255) NOT NULL, date_creation_ressource DATETIME NOT NULL, Id_Cours INT NOT NULL, INDEX IDX_939F45442BF880FE (Id_Cours), PRIMARY KEY(id_ressource)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE subscription_event (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, event_id INT NOT NULL, date DATE NOT NULL, INDEX IDX_C1960BD4A76ED395 (user_id), INDEX IDX_C1960BD471F7E88B (event_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, username VARCHAR(255) NOT NULL, roles JSON NOT NULL COMMENT \'(DC2Type:json)\', password VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_IDENTIFIER_EMAIL (email), UNIQUE INDEX UNIQ_IDENTIFIER_USERNAME (username), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', available_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', delivered_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE cours ADD CONSTRAINT FK_FDCA8C9C928C6DD3 FOREIGN KEY (id_enseignant_cours_id) REFERENCES enseignant (id)');
        $this->addSql('ALTER TABLE evenement ADD CONSTRAINT FK_B26681E12469DE2 FOREIGN KEY (category_id) REFERENCES category (idCategory)');
        $this->addSql('ALTER TABLE forum ADD CONSTRAINT FK_852BBECD12C40417 FOREIGN KEY (createur_forum) REFERENCES user (id)');
        $this->addSql('ALTER TABLE message_forum ADD CONSTRAINT FK_7A8D412673B893E1 FOREIGN KEY (CreateurMessageForum) REFERENCES user (id)');
        $this->addSql('ALTER TABLE message_forum ADD CONSTRAINT FK_7A8D41266BAEFFFD FOREIGN KEY (id_forum) REFERENCES forum (id_forum)');
        $this->addSql('ALTER TABLE projet ADD CONSTRAINT FK_50159CA9FD02F13 FOREIGN KEY (evenement_id) REFERENCES evenement (id)');
        $this->addSql('ALTER TABLE ressource ADD CONSTRAINT FK_939F45442BF880FE FOREIGN KEY (Id_Cours) REFERENCES cours (Id_Cours) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE subscription_event ADD CONSTRAINT FK_C1960BD4A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE subscription_event ADD CONSTRAINT FK_C1960BD471F7E88B FOREIGN KEY (event_id) REFERENCES evenement (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE cours DROP FOREIGN KEY FK_FDCA8C9C928C6DD3');
        $this->addSql('ALTER TABLE evenement DROP FOREIGN KEY FK_B26681E12469DE2');
        $this->addSql('ALTER TABLE forum DROP FOREIGN KEY FK_852BBECD12C40417');
        $this->addSql('ALTER TABLE message_forum DROP FOREIGN KEY FK_7A8D412673B893E1');
        $this->addSql('ALTER TABLE message_forum DROP FOREIGN KEY FK_7A8D41266BAEFFFD');
        $this->addSql('ALTER TABLE projet DROP FOREIGN KEY FK_50159CA9FD02F13');
        $this->addSql('ALTER TABLE ressource DROP FOREIGN KEY FK_939F45442BF880FE');
        $this->addSql('ALTER TABLE subscription_event DROP FOREIGN KEY FK_C1960BD4A76ED395');
        $this->addSql('ALTER TABLE subscription_event DROP FOREIGN KEY FK_C1960BD471F7E88B');
        $this->addSql('DROP TABLE category');
        $this->addSql('DROP TABLE chatbot');
        $this->addSql('DROP TABLE cours');
        $this->addSql('DROP TABLE enseignant');
        $this->addSql('DROP TABLE etudiant');
        $this->addSql('DROP TABLE evenement');
        $this->addSql('DROP TABLE forum');
        $this->addSql('DROP TABLE message_forum');
        $this->addSql('DROP TABLE projet');
        $this->addSql('DROP TABLE reclamation');
        $this->addSql('DROP TABLE ressource');
        $this->addSql('DROP TABLE subscription_event');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
