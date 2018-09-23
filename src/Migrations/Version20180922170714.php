<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20180922170714 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        $this->addSql('ALTER TABLE user ADD newsletter TINYINT(1) DEFAULT \'0\' NOT NULL, CHANGE enabled enabled TINYINT(1) DEFAULT \'0\' NOT NULL, CHANGE admin admin TINYINT(1) DEFAULT \'0\' NOT NULL');
        $this->addSql('UPDATE user SET newsletter = 1');
    }

    public function down(Schema $schema) : void
    {
        $this->addSql('ALTER TABLE user DROP newsletter, CHANGE enabled enabled TINYINT(1) NOT NULL, CHANGE admin admin TINYINT(1) NOT NULL');
    }
}
