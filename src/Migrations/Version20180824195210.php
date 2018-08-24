<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20180824195210 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        $this->addSql('CREATE TABLE photo_publication (id INT AUTO_INCREMENT NOT NULL, published_at DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE photo ADD publication_id INT DEFAULT NULL, DROP published_at');
        $this->addSql('ALTER TABLE photo ADD CONSTRAINT FK_14B7841838B217A7 FOREIGN KEY (publication_id) REFERENCES photo_publication (id)');
        $this->addSql('CREATE INDEX IDX_14B7841838B217A7 ON photo (publication_id)');
    }

    public function down(Schema $schema) : void
    {
        $this->addSql('ALTER TABLE photo DROP FOREIGN KEY FK_14B7841838B217A7');
        $this->addSql('DROP TABLE photo_publication');
        $this->addSql('DROP INDEX IDX_14B7841838B217A7 ON photo');
        $this->addSql('ALTER TABLE photo ADD published_at DATETIME DEFAULT NULL, DROP publication_id');
    }
}
