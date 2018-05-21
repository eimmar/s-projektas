<?php declare(strict_types = 1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20180519140809 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE visit_service ADD quantity INT NOT NULL');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_41C081295E237E06 ON visit_status (name)');
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE FULLTEXT INDEX fulltext_index20180424 ON service (name, description)');
        $this->addSql('CREATE FULLTEXT INDEX fulltext_index201804241 ON service_type (name)');
        $this->addSql('ALTER TABLE visit_service DROP quantity');
        $this->addSql('DROP INDEX UNIQ_41C081295E237E06 ON visit_status');
    }
}
