<?php

declare(strict_types=1);

namespace App\Modal\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210309185852 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE article ADD created DATETIME NOT NULL');
        $this->addSql('ALTER TABLE image ADD created DATETIME NOT NULL');
        $this->addSql('ALTER TABLE users ADD created DATETIME NOT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE article DROP created');
        $this->addSql('ALTER TABLE image DROP created');
        $this->addSql('ALTER TABLE users DROP created');
    }
}
