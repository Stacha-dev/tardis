<?php

declare(strict_types=1);

namespace App\Modal\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210310182327 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE menu (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(512) NOT NULL, updated TIMESTAMP DEFAULT CURRENT_TIMESTAMP NOT NULL, created DATETIME NOT NULL, state TINYINT(1) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE menu_item (id INT AUTO_INCREMENT NOT NULL, menu_id INT DEFAULT NULL, title VARCHAR(512) NOT NULL, target VARCHAR(512) NOT NULL, updated TIMESTAMP DEFAULT CURRENT_TIMESTAMP NOT NULL, created DATETIME NOT NULL, state TINYINT(1) NOT NULL, INDEX IDX_D754D550CCD7E912 (menu_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE menu_item ADD CONSTRAINT FK_D754D550CCD7E912 FOREIGN KEY (menu_id) REFERENCES menu (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE menu_item DROP FOREIGN KEY FK_D754D550CCD7E912');
        $this->addSql('DROP TABLE menu');
        $this->addSql('DROP TABLE menu_item');
    }
}
