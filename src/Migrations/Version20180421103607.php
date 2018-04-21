<?php declare(strict_types = 1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20180421103607 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE company_address (id INT AUTO_INCREMENT NOT NULL, city_id INT DEFAULT NULL, street VARCHAR(255) DEFAULT NULL, comment VARCHAR(255) DEFAULT NULL, INDEX IDX_2D1C75568BAC62AF (city_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE company_address ADD CONSTRAINT FK_2D1C75568BAC62AF FOREIGN KEY (city_id) REFERENCES city (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_5373C9665E237E06 ON country (name)');
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE company_address');
        $this->addSql('DROP INDEX UNIQ_5373C9665E237E06 ON country');
    }
}
