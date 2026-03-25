<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260220205324 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE avancement (id INT AUTO_INCREMENT NOT NULL, description LONGTEXT NOT NULL, pourcentage INT NOT NULL, created_at DATETIME NOT NULL, chantier_id INT NOT NULL, entrepreneur_id INT NOT NULL, INDEX IDX_6D2A7A2AD0C0049D (chantier_id), INDEX IDX_6D2A7A2A283063EA (entrepreneur_id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE avancement_photo (id INT AUTO_INCREMENT NOT NULL, fichier VARCHAR(255) DEFAULT NULL, avancement_id INT NOT NULL, INDEX IDX_45AA1935DF05EC1 (avancement_id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE devis_entrepreneur (id INT AUTO_INCREMENT NOT NULL, fichier_pdf VARCHAR(255) DEFAULT NULL, prix_total NUMERIC(10, 2) NOT NULL, date_debut_travaux DATE NOT NULL, created_at DATETIME NOT NULL, proposition_id INT NOT NULL, UNIQUE INDEX UNIQ_8525C1FEDB96F9E (proposition_id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE inspection_document (id INT AUTO_INCREMENT NOT NULL, type VARCHAR(50) NOT NULL, fichier VARCHAR(255) DEFAULT NULL, observations LONGTEXT DEFAULT NULL, created_at DATETIME NOT NULL, chantier_id INT NOT NULL, INDEX IDX_2B78AE2DD0C0049D (chantier_id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE inspection_photo (id INT AUTO_INCREMENT NOT NULL, fichier VARCHAR(255) DEFAULT NULL, description VARCHAR(255) DEFAULT NULL, created_at DATETIME NOT NULL, chantier_id INT NOT NULL, INDEX IDX_9CCA34D0C0049D (chantier_id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE proposition_chantier (id INT AUTO_INCREMENT NOT NULL, statut VARCHAR(30) NOT NULL, created_at DATETIME NOT NULL, chantier_id INT NOT NULL, entrepreneur_id INT NOT NULL, INDEX IDX_537E8FB6D0C0049D (chantier_id), INDEX IDX_537E8FB6283063EA (entrepreneur_id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE reception (id INT AUTO_INCREMENT NOT NULL, date_reception DATE NOT NULL, conforme TINYINT NOT NULL, reserves LONGTEXT DEFAULT NULL, fichier_pv VARCHAR(255) DEFAULT NULL, chantier_id INT NOT NULL, UNIQUE INDEX UNIQ_50D6852FD0C0049D (chantier_id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE user_web (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, nom VARCHAR(100) NOT NULL, inspecteur_id INT DEFAULT NULL, entrepreneur_id INT DEFAULT NULL, proprietaire_id INT DEFAULT NULL, UNIQUE INDEX UNIQ_FEDF59DAE7927C74 (email), INDEX IDX_FEDF59DAB7728AA0 (inspecteur_id), INDEX IDX_FEDF59DA283063EA (entrepreneur_id), INDEX IDX_FEDF59DA76C50E4A (proprietaire_id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL, available_at DATETIME NOT NULL, delivered_at DATETIME DEFAULT NULL, INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('ALTER TABLE avancement ADD CONSTRAINT FK_6D2A7A2AD0C0049D FOREIGN KEY (chantier_id) REFERENCES chantier (id)');
        $this->addSql('ALTER TABLE avancement ADD CONSTRAINT FK_6D2A7A2A283063EA FOREIGN KEY (entrepreneur_id) REFERENCES entrepreneur (id)');
        $this->addSql('ALTER TABLE avancement_photo ADD CONSTRAINT FK_45AA1935DF05EC1 FOREIGN KEY (avancement_id) REFERENCES avancement (id)');
        $this->addSql('ALTER TABLE devis_entrepreneur ADD CONSTRAINT FK_8525C1FEDB96F9E FOREIGN KEY (proposition_id) REFERENCES proposition_chantier (id)');
        $this->addSql('ALTER TABLE inspection_document ADD CONSTRAINT FK_2B78AE2DD0C0049D FOREIGN KEY (chantier_id) REFERENCES chantier (id)');
        $this->addSql('ALTER TABLE inspection_photo ADD CONSTRAINT FK_9CCA34D0C0049D FOREIGN KEY (chantier_id) REFERENCES chantier (id)');
        $this->addSql('ALTER TABLE proposition_chantier ADD CONSTRAINT FK_537E8FB6D0C0049D FOREIGN KEY (chantier_id) REFERENCES chantier (id)');
        $this->addSql('ALTER TABLE proposition_chantier ADD CONSTRAINT FK_537E8FB6283063EA FOREIGN KEY (entrepreneur_id) REFERENCES entrepreneur (id)');
        $this->addSql('ALTER TABLE reception ADD CONSTRAINT FK_50D6852FD0C0049D FOREIGN KEY (chantier_id) REFERENCES chantier (id)');
        $this->addSql('ALTER TABLE user_web ADD CONSTRAINT FK_FEDF59DAB7728AA0 FOREIGN KEY (inspecteur_id) REFERENCES inspecteur (id)');
        $this->addSql('ALTER TABLE user_web ADD CONSTRAINT FK_FEDF59DA283063EA FOREIGN KEY (entrepreneur_id) REFERENCES entrepreneur (id)');
        $this->addSql('ALTER TABLE user_web ADD CONSTRAINT FK_FEDF59DA76C50E4A FOREIGN KEY (proprietaire_id) REFERENCES proprietaire (id)');
        // Ajout colonne statut à chantier (ne touche pas aux FK/tables existantes)
        $this->addSql('ALTER TABLE chantier ADD statut VARCHAR(30) DEFAULT \'cree\'');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE utilisateur (id INT AUTO_INCREMENT NOT NULL, login VARCHAR(50) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, mot_de_passe VARCHAR(100) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, UNIQUE INDEX login (login), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE avancement DROP FOREIGN KEY FK_6D2A7A2AD0C0049D');
        $this->addSql('ALTER TABLE avancement DROP FOREIGN KEY FK_6D2A7A2A283063EA');
        $this->addSql('ALTER TABLE avancement_photo DROP FOREIGN KEY FK_45AA1935DF05EC1');
        $this->addSql('ALTER TABLE devis_entrepreneur DROP FOREIGN KEY FK_8525C1FEDB96F9E');
        $this->addSql('ALTER TABLE inspection_document DROP FOREIGN KEY FK_2B78AE2DD0C0049D');
        $this->addSql('ALTER TABLE inspection_photo DROP FOREIGN KEY FK_9CCA34D0C0049D');
        $this->addSql('ALTER TABLE proposition_chantier DROP FOREIGN KEY FK_537E8FB6D0C0049D');
        $this->addSql('ALTER TABLE proposition_chantier DROP FOREIGN KEY FK_537E8FB6283063EA');
        $this->addSql('ALTER TABLE reception DROP FOREIGN KEY FK_50D6852FD0C0049D');
        $this->addSql('ALTER TABLE user_web DROP FOREIGN KEY FK_FEDF59DAB7728AA0');
        $this->addSql('ALTER TABLE user_web DROP FOREIGN KEY FK_FEDF59DA283063EA');
        $this->addSql('ALTER TABLE user_web DROP FOREIGN KEY FK_FEDF59DA76C50E4A');
        $this->addSql('DROP TABLE avancement');
        $this->addSql('DROP TABLE avancement_photo');
        $this->addSql('DROP TABLE devis_entrepreneur');
        $this->addSql('DROP TABLE inspection_document');
        $this->addSql('DROP TABLE inspection_photo');
        $this->addSql('DROP TABLE proposition_chantier');
        $this->addSql('DROP TABLE reception');
        $this->addSql('DROP TABLE user_web');
        $this->addSql('DROP TABLE messenger_messages');
        $this->addSql('ALTER TABLE bien DROP FOREIGN KEY FK_45EDC38676C50E4A');
        $this->addSql('ALTER TABLE bien ADD CONSTRAINT `fk_bien_proprietaire` FOREIGN KEY (proprietaire_id) REFERENCES proprietaire (id) ON UPDATE CASCADE');
        $this->addSql('ALTER TABLE bien RENAME INDEX idx_45edc38676c50e4a TO fk_bien_proprietaire');
        $this->addSql('ALTER TABLE chantier DROP FOREIGN KEY FK_636F27F6BD95B80F');
        $this->addSql('ALTER TABLE chantier DROP FOREIGN KEY FK_636F27F6B7728AA0');
        $this->addSql('ALTER TABLE chantier DROP statut');
        $this->addSql('ALTER TABLE chantier ADD CONSTRAINT `fk_chantier_bien` FOREIGN KEY (bien_id) REFERENCES bien (id) ON UPDATE CASCADE');
        $this->addSql('ALTER TABLE chantier ADD CONSTRAINT `fk_chantier_inspecteur` FOREIGN KEY (inspecteur_id) REFERENCES inspecteur (id) ON UPDATE CASCADE');
        $this->addSql('ALTER TABLE chantier RENAME INDEX idx_636f27f6b7728aa0 TO fk_chantier_inspecteur');
        $this->addSql('ALTER TABLE chantier RENAME INDEX idx_636f27f6bd95b80f TO fk_chantier_bien');
        $this->addSql('ALTER TABLE devis_type_ligne DROP FOREIGN KEY FK_E95D179CD0C0049D');
        $this->addSql('ALTER TABLE devis_type_ligne DROP FOREIGN KEY FK_E95D179C9E45C554');
        $this->addSql('ALTER TABLE devis_type_ligne ADD CONSTRAINT `fk_devis_chantier` FOREIGN KEY (chantier_id) REFERENCES chantier (id) ON UPDATE CASCADE ON DELETE CASCADE');
        $this->addSql('ALTER TABLE devis_type_ligne ADD CONSTRAINT `fk_devis_prestation` FOREIGN KEY (prestation_id) REFERENCES prestation (id) ON UPDATE CASCADE');
        $this->addSql('ALTER TABLE devis_type_ligne RENAME INDEX idx_e95d179c9e45c554 TO fk_devis_prestation');
        $this->addSql('ALTER TABLE devis_type_ligne RENAME INDEX idx_e95d179cd0c0049d TO fk_devis_chantier');
        $this->addSql('ALTER TABLE entrepreneur DROP FOREIGN KEY FK_F28C90A3BCF5E72D');
        $this->addSql('ALTER TABLE entrepreneur ADD CONSTRAINT `fk_entrepreneur_categorie` FOREIGN KEY (categorie_id) REFERENCES categorie_entrepreneur (id) ON UPDATE CASCADE');
        $this->addSql('ALTER TABLE entrepreneur RENAME INDEX idx_f28c90a3bcf5e72d TO fk_entrepreneur_categorie');
        $this->addSql('ALTER TABLE entrepreneur_categorie_prestation DROP FOREIGN KEY FK_3F9DCBD8283063EA');
        $this->addSql('ALTER TABLE entrepreneur_categorie_prestation DROP FOREIGN KEY FK_3F9DCBD89D8A241E');
        $this->addSql('ALTER TABLE entrepreneur_categorie_prestation ADD CONSTRAINT `fk_ecp_categorie` FOREIGN KEY (categorie_prestation_id) REFERENCES categorie_prestation (id) ON UPDATE CASCADE ON DELETE CASCADE');
        $this->addSql('ALTER TABLE entrepreneur_categorie_prestation ADD CONSTRAINT `fk_ecp_entrepreneur` FOREIGN KEY (entrepreneur_id) REFERENCES entrepreneur (id) ON UPDATE CASCADE ON DELETE CASCADE');
        $this->addSql('ALTER TABLE entrepreneur_categorie_prestation RENAME INDEX idx_3f9dcbd89d8a241e TO fk_ecp_categorie');
        $this->addSql('ALTER TABLE prestation DROP FOREIGN KEY FK_51C88FADBCF5E72D');
        $this->addSql('ALTER TABLE prestation ADD CONSTRAINT `fk_prestation_categorie` FOREIGN KEY (categorie_id) REFERENCES categorie_prestation (id) ON UPDATE CASCADE');
        $this->addSql('ALTER TABLE prestation RENAME INDEX idx_51c88fadbcf5e72d TO fk_prestation_categorie');
    }
}
