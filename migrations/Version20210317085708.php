<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210317085708 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE demande (id INT AUTO_INCREMENT NOT NULL, person_asking_id INT NOT NULL, obj_requested_id INT NOT NULL, date DATETIME NOT NULL, INDEX IDX_2694D7A5885EA8A9 (person_asking_id), INDEX IDX_2694D7A5225B00B4 (obj_requested_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE demandeur (id INT AUTO_INCREMENT NOT NULL, lastname VARCHAR(255) NOT NULL, firstname VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, phone_number VARCHAR(255) NOT NULL, company VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE obj (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, photo_link VARCHAR(255) DEFAULT NULL, video_link VARCHAR(255) DEFAULT NULL, summarize LONGTEXT DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE demande ADD CONSTRAINT FK_2694D7A5885EA8A9 FOREIGN KEY (person_asking_id) REFERENCES demandeur (id)');
        $this->addSql('ALTER TABLE demande ADD CONSTRAINT FK_2694D7A5225B00B4 FOREIGN KEY (obj_requested_id) REFERENCES obj (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE demande DROP FOREIGN KEY FK_2694D7A5885EA8A9');
        $this->addSql('ALTER TABLE demande DROP FOREIGN KEY FK_2694D7A5225B00B4');
        $this->addSql('DROP TABLE demande');
        $this->addSql('DROP TABLE demandeur');
        $this->addSql('DROP TABLE obj');
    }
}
