<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20180826200840 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        $this->addSql('CREATE TABLE photo (id INT AUTO_INCREMENT NOT NULL, uploaded_by_id INT NOT NULL, publication_id INT DEFAULT NULL, label VARCHAR(255) DEFAULT NULL, description LONGTEXT DEFAULT NULL, original VARCHAR(40) NOT NULL, taken_at DATETIME DEFAULT NULL, deleted_at DATETIME DEFAULT NULL, web VARCHAR(40) NOT NULL, thumb VARCHAR(40) NOT NULL, UNIQUE INDEX UNIQ_14B784182F727085 (original), INDEX IDX_14B78418A2B28FE8 (uploaded_by_id), INDEX IDX_14B7841838B217A7 (publication_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE photo_publication (id INT AUTO_INCREMENT NOT NULL, published_at DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(255) NOT NULL, password VARCHAR(95) NOT NULL, first_name VARCHAR(255) NOT NULL, last_name VARCHAR(255) NOT NULL, phone VARCHAR(255) NOT NULL, enabled TINYINT(1) NOT NULL, admin TINYINT(1) NOT NULL, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE photo ADD CONSTRAINT FK_14B78418A2B28FE8 FOREIGN KEY (uploaded_by_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE photo ADD CONSTRAINT FK_14B7841838B217A7 FOREIGN KEY (publication_id) REFERENCES photo_publication (id)');
    }

    public function down(Schema $schema) : void
    {
        $this->addSql('ALTER TABLE photo DROP FOREIGN KEY FK_14B7841838B217A7');
        $this->addSql('ALTER TABLE photo DROP FOREIGN KEY FK_14B78418A2B28FE8');
        $this->addSql('DROP TABLE photo');
        $this->addSql('DROP TABLE photo_publication');
        $this->addSql('DROP TABLE user');
    }
}
