<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20180807164131 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        $this->addSql('CREATE TABLE photo (id INT AUTO_INCREMENT NOT NULL, uploaded_by_id INT NOT NULL, label VARCHAR(255) DEFAULT NULL, description LONGTEXT DEFAULT NULL, file_name VARCHAR(40) NOT NULL, taken_at DATETIME DEFAULT NULL, published_at DATETIME DEFAULT NULL, UNIQUE INDEX UNIQ_14B78418D7DF1668 (file_name), INDEX IDX_14B78418A2B28FE8 (uploaded_by_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE photo ADD CONSTRAINT FK_14B78418A2B28FE8 FOREIGN KEY (uploaded_by_id) REFERENCES user (id)');
    }

    public function down(Schema $schema) : void
    {
        $this->addSql('DROP TABLE photo');
    }
}
