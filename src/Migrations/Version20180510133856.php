<?php declare(strict_types = 1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20180510133856 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE service_visit_history (id INT AUTO_INCREMENT NOT NULL, service_id_id INT NOT NULL, visit_id_id INT NOT NULL, price DOUBLE PRECISION NOT NULL, description VARCHAR(65535) DEFAULT NULL, duration INT NOT NULL, visit_date DATETIME NOT NULL, date_created DATETIME NOT NULL, date_updated DATETIME NOT NULL, INDEX IDX_A18CCE0ED63673B0 (service_id_id), INDEX IDX_A18CCE0EAF16536 (visit_id_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE visits (id INT AUTO_INCREMENT NOT NULL, status_id_id INT NOT NULL, visit_date DATETIME NOT NULL, date_created DATETIME NOT NULL, date_updated DATETIME NOT NULL, INDEX IDX_444839EA881ECFA7 (status_id_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE service_visit_history ADD CONSTRAINT FK_A18CCE0ED63673B0 FOREIGN KEY (service_id_id) REFERENCES service (id)');
        $this->addSql('ALTER TABLE service_visit_history ADD CONSTRAINT FK_A18CCE0EAF16536 FOREIGN KEY (visit_id_id) REFERENCES visits (id)');
        $this->addSql('ALTER TABLE visits ADD CONSTRAINT FK_444839EA881ECFA7 FOREIGN KEY (status_id_id) REFERENCES visit_statuses (id)');
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE service_visit_history DROP FOREIGN KEY FK_A18CCE0EAF16536');
        $this->addSql('DROP TABLE service_visit_history');
        $this->addSql('DROP TABLE visits');
    }
}
