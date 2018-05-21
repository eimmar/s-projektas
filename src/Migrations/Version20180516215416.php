<?php declare(strict_types = 1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20180516215416 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE visit_service (id INT AUTO_INCREMENT NOT NULL, service_id INT NOT NULL, visit_id INT NOT NULL, price DOUBLE PRECISION NOT NULL, description TEXT DEFAULT NULL, duration INT NOT NULL, date_created DATETIME NOT NULL, date_updated DATETIME NOT NULL, INDEX IDX_B7149E15ED5CA9E6 (service_id), INDEX IDX_B7149E1575FA0FF2 (visit_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE visit_service ADD CONSTRAINT FK_B7149E15ED5CA9E6 FOREIGN KEY (service_id) REFERENCES service (id)');
        $this->addSql('ALTER TABLE visit_service ADD CONSTRAINT FK_B7149E1575FA0FF2 FOREIGN KEY (visit_id) REFERENCES visit (id)');
        $this->addSql('DROP TABLE service_history');
        $this->addSql('ALTER TABLE visit ADD vehicle_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE visit ADD CONSTRAINT FK_437EE939545317D1 FOREIGN KEY (vehicle_id) REFERENCES vehicle (id)');
        $this->addSql('CREATE INDEX IDX_437EE939545317D1 ON visit (vehicle_id)');
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE service_history (id INT AUTO_INCREMENT NOT NULL, service_id INT NOT NULL, visit_id INT NOT NULL, price DOUBLE PRECISION NOT NULL, description TEXT DEFAULT NULL COLLATE utf8mb4_unicode_ci, duration INT NOT NULL, date_created DATETIME NOT NULL, date_updated DATETIME NOT NULL, INDEX IDX_E83E22D7ED5CA9E6 (service_id), INDEX IDX_E83E22D775FA0FF2 (visit_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE service_history ADD CONSTRAINT FK_E83E22D775FA0FF2 FOREIGN KEY (visit_id) REFERENCES visit (id)');
        $this->addSql('ALTER TABLE service_history ADD CONSTRAINT FK_E83E22D7ED5CA9E6 FOREIGN KEY (service_id) REFERENCES service (id)');
        $this->addSql('DROP TABLE visit_service');
        $this->addSql('ALTER TABLE visit DROP FOREIGN KEY FK_437EE939545317D1');
        $this->addSql('ALTER TABLE visit DROP vehicle_id');
        $this->addSql('DROP INDEX IDX_437EE939545317D1 ON visit');
    }
}
