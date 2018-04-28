<?php declare(strict_types = 1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20180428190214 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE config (id INT AUTO_INCREMENT NOT NULL, user_changed_by_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, value VARCHAR(255) DEFAULT NULL, description VARCHAR(255) DEFAULT NULL, date_created DATETIME NOT NULL, date_updated DATETIME NOT NULL, INDEX IDX_D48A2F7C6C047DF0 (user_changed_by_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE config ADD CONSTRAINT FK_D48A2F7C6C047DF0 FOREIGN KEY (user_changed_by_id) REFERENCES users (id)');
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE config');
    }
}
