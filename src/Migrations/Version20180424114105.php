<?php declare(strict_types = 1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20180424114105 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE IF NOT EXIST transmition_types (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE IF NOT EXIST visit_statuses (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE IF NOT EXIST fuel_types (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE IF NOT EXIST vehicles (id INT AUTO_INCREMENT NOT NULL, model_id_id INT NOT NULL, user_id_id INT NOT NULL, transmition_type_id_id INT NOT NULL, fuel_type_id_id INT NOT NULL, power_kw INT NOT NULL, engine_capacity INT NOT NULL, year_made INT NOT NULL, month_made INT NOT NULL, date_created DATETIME NOT NULL, date_modified DATETIME NOT NULL, INDEX IDX_1FCE69FA4107BEA0 (model_id_id), INDEX IDX_1FCE69FA9D86650F (user_id_id), INDEX IDX_1FCE69FAFF75FC6C (transmition_type_id_id), INDEX IDX_1FCE69FA9EDB5F2E (fuel_type_id_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE IF NOT EXIST manufacturers (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE IF NOT EXIST service_visit_history (id INT AUTO_INCREMENT NOT NULL, service_id_id INT NOT NULL, visit_id_id INT NOT NULL, price DOUBLE PRECISION NOT NULL, description VARCHAR(65535) DEFAULT NULL, duration INT NOT NULL, visit_date DATETIME NOT NULL, date_created DATETIME NOT NULL, date_updated DATETIME NOT NULL, INDEX IDX_A18CCE0ED63673B0 (service_id_id), INDEX IDX_A18CCE0EAF16536 (visit_id_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE IF NOT EXIST models (id INT AUTO_INCREMENT NOT NULL, manufacturer_id_id INT NOT NULL, name VARCHAR(255) NOT NULL, INDEX IDX_E4D63009741A0A47 (manufacturer_id_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE IF NOT EXIST visits (id INT AUTO_INCREMENT NOT NULL, vehicle_id_id INT NOT NULL, status_id_id INT NOT NULL, visit_date DATETIME NOT NULL, date_created DATETIME NOT NULL, date_updated DATETIME NOT NULL, INDEX IDX_444839EA1DEB1EBB (vehicle_id_id), INDEX IDX_444839EA881ECFA7 (status_id_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE IF NOT EXIST vehicles ADD CONSTRAINT FK_1FCE69FA4107BEA0 FOREIGN KEY (model_id_id) REFERENCES models (id)');
        $this->addSql('ALTER TABLE IF NOT EXIST vehicles ADD CONSTRAINT FK_1FCE69FA9D86650F FOREIGN KEY (user_id_id) REFERENCES users (id)');
        $this->addSql('ALTER TABLE IF NOT EXIST vehicles ADD CONSTRAINT FK_1FCE69FAFF75FC6C FOREIGN KEY (transmition_type_id_id) REFERENCES transmition_types (id)');
        $this->addSql('ALTER TABLE IF NOT EXIST vehicles ADD CONSTRAINT FK_1FCE69FA9EDB5F2E FOREIGN KEY (fuel_type_id_id) REFERENCES fuel_types (id)');
        $this->addSql('ALTER TABLE IF NOT EXIST service_visit_history ADD CONSTRAINT FK_A18CCE0ED63673B0 FOREIGN KEY (service_id_id) REFERENCES service (id)');
        $this->addSql('ALTER TABLE IF NOT EXIST service_visit_history ADD CONSTRAINT FK_A18CCE0EAF16536 FOREIGN KEY (visit_id_id) REFERENCES visits (id)');
        $this->addSql('ALTER TABLE IF NOT EXIST models ADD CONSTRAINT FK_E4D63009741A0A47 FOREIGN KEY (manufacturer_id_id) REFERENCES manufacturers (id)');
        $this->addSql('ALTER TABLE IF NOT EXIST visits ADD CONSTRAINT FK_444839EA1DEB1EBB FOREIGN KEY (vehicle_id_id) REFERENCES vehicles (id)');
        $this->addSql('ALTER TABLE IF NOT EXIST visits ADD CONSTRAINT FK_444839EA881ECFA7 FOREIGN KEY (status_id_id) REFERENCES visit_statuses (id)');
        $this->addSql('ALTER TABLE IF NOT EXIST service CHANGE description description VARCHAR(65535) DEFAULT NULL');
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE vehicles DROP FOREIGN KEY FK_1FCE69FAFF75FC6C');
        $this->addSql('ALTER TABLE visits DROP FOREIGN KEY FK_444839EA881ECFA7');
        $this->addSql('ALTER TABLE vehicles DROP FOREIGN KEY FK_1FCE69FA9EDB5F2E');
        $this->addSql('ALTER TABLE visits DROP FOREIGN KEY FK_444839EA1DEB1EBB');
        $this->addSql('ALTER TABLE models DROP FOREIGN KEY FK_E4D63009741A0A47');
        $this->addSql('ALTER TABLE vehicles DROP FOREIGN KEY FK_1FCE69FA4107BEA0');
        $this->addSql('ALTER TABLE service_visit_history DROP FOREIGN KEY FK_A18CCE0EAF16536');
        $this->addSql('DROP TABLE transmition_types');
        $this->addSql('DROP TABLE visit_statuses');
        $this->addSql('DROP TABLE fuel_types');
        $this->addSql('DROP TABLE vehicles');
        $this->addSql('DROP TABLE manufacturers');
        $this->addSql('DROP TABLE service_visit_history');
        $this->addSql('DROP TABLE models');
        $this->addSql('DROP TABLE visits');
        $this->addSql('ALTER TABLE service CHANGE description description MEDIUMTEXT DEFAULT NULL COLLATE utf8mb4_unicode_ci');
    }
}
