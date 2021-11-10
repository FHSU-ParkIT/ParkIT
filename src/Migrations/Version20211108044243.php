<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211108044243 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE license_plate (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, plate_number VARCHAR(8) NOT NULL, INDEX IDX_F5AA79D0A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE parking_spot (id INT AUTO_INCREMENT NOT NULL, lot_name VARCHAR(255) NOT NULL, spot_number INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE reservation (id INT AUTO_INCREMENT NOT NULL, license_plate_id INT NOT NULL, parking_spot_id INT NOT NULL, start_date_time DATETIME NOT NULL, end_date_time DATETIME NOT NULL, INDEX IDX_42C84955233678BC (license_plate_id), INDEX IDX_42C84955A31B2BA6 (parking_spot_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE license_plate ADD CONSTRAINT FK_F5AA79D0A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE reservation ADD CONSTRAINT FK_42C84955233678BC FOREIGN KEY (license_plate_id) REFERENCES license_plate (id)');
        $this->addSql('ALTER TABLE reservation ADD CONSTRAINT FK_42C84955A31B2BA6 FOREIGN KEY (parking_spot_id) REFERENCES parking_spot (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE reservation DROP FOREIGN KEY FK_42C84955233678BC');
        $this->addSql('ALTER TABLE reservation DROP FOREIGN KEY FK_42C84955A31B2BA6');
        $this->addSql('DROP TABLE license_plate');
        $this->addSql('DROP TABLE parking_spot');
        $this->addSql('DROP TABLE reservation');
    }
}
