<?php declare(strict_types = 1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20180514193610 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE service_history (id INT AUTO_INCREMENT NOT NULL, service_id INT NOT NULL, visit_id INT NOT NULL, price DOUBLE PRECISION NOT NULL, description TEXT DEFAULT NULL, duration INT NOT NULL, date_created DATETIME NOT NULL, date_updated DATETIME NOT NULL, INDEX IDX_E83E22D7ED5CA9E6 (service_id), INDEX IDX_E83E22D775FA0FF2 (visit_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE visit_status (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE transmission_type (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE model (id INT AUTO_INCREMENT NOT NULL, manufacturer_id INT NOT NULL, name VARCHAR(255) NOT NULL, INDEX IDX_D79572D9A23B42D (manufacturer_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE fuel_type (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE service_history ADD CONSTRAINT FK_E83E22D7ED5CA9E6 FOREIGN KEY (service_id) REFERENCES service (id)');
        $this->addSql('ALTER TABLE service_history ADD CONSTRAINT FK_E83E22D775FA0FF2 FOREIGN KEY (visit_id) REFERENCES visit (id)');
        $this->addSql('ALTER TABLE model ADD CONSTRAINT FK_D79572D9A23B42D FOREIGN KEY (manufacturer_id) REFERENCES manufacturer (id)');
        $this->addSql('ALTER TABLE vehicle ADD CONSTRAINT FK_1B80E4867975B7E7 FOREIGN KEY (model_id) REFERENCES model (id)');
        $this->addSql('ALTER TABLE vehicle ADD CONSTRAINT FK_1B80E486A76ED395 FOREIGN KEY (user_id) REFERENCES users (id)');
        $this->addSql('ALTER TABLE vehicle ADD CONSTRAINT FK_1B80E486CDD541D0 FOREIGN KEY (transmission_type_id) REFERENCES transmission_type (id)');
        $this->addSql('ALTER TABLE vehicle ADD CONSTRAINT FK_1B80E4866A70FE35 FOREIGN KEY (fuel_type_id) REFERENCES fuel_type (id)');
        $this->addSql('ALTER TABLE visit ADD CONSTRAINT FK_437EE9396BF700BD FOREIGN KEY (status_id) REFERENCES visit_status (id)');
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE visit DROP FOREIGN KEY FK_437EE9396BF700BD');
        $this->addSql('ALTER TABLE vehicle DROP FOREIGN KEY FK_1B80E486CDD541D0');
        $this->addSql('ALTER TABLE vehicle DROP FOREIGN KEY FK_1B80E4867975B7E7');
        $this->addSql('ALTER TABLE vehicle DROP FOREIGN KEY FK_1B80E4866A70FE35');
        $this->addSql('DROP TABLE service_history');
        $this->addSql('DROP TABLE visit_status');
        $this->addSql('DROP TABLE transmission_type');
        $this->addSql('DROP TABLE model');
        $this->addSql('DROP TABLE fuel_type');
        $this->addSql('ALTER TABLE vehicle DROP FOREIGN KEY FK_1B80E486A76ED395');
    }
}
