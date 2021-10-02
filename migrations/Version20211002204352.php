<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211002204352 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE ticket (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, user_id INTEGER NOT NULL, route_id INTEGER NOT NULL, is_paid BOOLEAN NOT NULL)');
        $this->addSql('CREATE INDEX IDX_97A0ADA3A76ED395 ON ticket (user_id)');
        $this->addSql('CREATE INDEX IDX_97A0ADA334ECB4E6 ON ticket (route_id)');
        $this->addSql('CREATE TABLE user (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, name VARCHAR(255) NOT NULL, last_name VARCHAR(255) NOT NULL, second_name VARCHAR(255) DEFAULT NULL)');
        $this->addSql('DROP INDEX IDX_2C4207968B33553');
        $this->addSql('DROP INDEX IDX_2C4207931687C55');
        $this->addSql('CREATE TEMPORARY TABLE __temp__route AS SELECT id, station_from_id, station_to_id, date_start, date_end, price FROM route');
        $this->addSql('DROP TABLE route');
        $this->addSql('CREATE TABLE route (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, station_from_id INTEGER NOT NULL, station_to_id INTEGER NOT NULL, date_start DATETIME NOT NULL, date_end DATETIME NOT NULL, price DOUBLE PRECISION DEFAULT NULL, CONSTRAINT FK_2C4207931687C55 FOREIGN KEY (station_from_id) REFERENCES station (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_2C4207968B33553 FOREIGN KEY (station_to_id) REFERENCES station (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO route (id, station_from_id, station_to_id, date_start, date_end, price) SELECT id, station_from_id, station_to_id, date_start, date_end, price FROM __temp__route');
        $this->addSql('DROP TABLE __temp__route');
        $this->addSql('CREATE INDEX IDX_2C4207968B33553 ON route (station_to_id)');
        $this->addSql('CREATE INDEX IDX_2C4207931687C55 ON route (station_from_id)');
        $this->addSql('DROP INDEX IDX_C119D60D23BCD4D0');
        $this->addSql('DROP INDEX IDX_C119D60D34ECB4E6');
        $this->addSql('CREATE TEMPORARY TABLE __temp__route_train AS SELECT route_id, train_id FROM route_train');
        $this->addSql('DROP TABLE route_train');
        $this->addSql('CREATE TABLE route_train (route_id INTEGER NOT NULL, train_id INTEGER NOT NULL, PRIMARY KEY(route_id, train_id), CONSTRAINT FK_C119D60D34ECB4E6 FOREIGN KEY (route_id) REFERENCES route (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_C119D60D23BCD4D0 FOREIGN KEY (train_id) REFERENCES train (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO route_train (route_id, train_id) SELECT route_id, train_id FROM __temp__route_train');
        $this->addSql('DROP TABLE __temp__route_train');
        $this->addSql('CREATE INDEX IDX_C119D60D23BCD4D0 ON route_train (train_id)');
        $this->addSql('CREATE INDEX IDX_C119D60D34ECB4E6 ON route_train (route_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE ticket');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP INDEX IDX_2C4207931687C55');
        $this->addSql('DROP INDEX IDX_2C4207968B33553');
        $this->addSql('CREATE TEMPORARY TABLE __temp__route AS SELECT id, station_from_id, station_to_id, date_start, date_end, price FROM route');
        $this->addSql('DROP TABLE route');
        $this->addSql('CREATE TABLE route (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, station_from_id INTEGER NOT NULL, station_to_id INTEGER NOT NULL, date_start DATETIME NOT NULL, date_end DATETIME NOT NULL, price DOUBLE PRECISION DEFAULT NULL)');
        $this->addSql('INSERT INTO route (id, station_from_id, station_to_id, date_start, date_end, price) SELECT id, station_from_id, station_to_id, date_start, date_end, price FROM __temp__route');
        $this->addSql('DROP TABLE __temp__route');
        $this->addSql('CREATE INDEX IDX_2C4207931687C55 ON route (station_from_id)');
        $this->addSql('CREATE INDEX IDX_2C4207968B33553 ON route (station_to_id)');
        $this->addSql('DROP INDEX IDX_C119D60D34ECB4E6');
        $this->addSql('DROP INDEX IDX_C119D60D23BCD4D0');
        $this->addSql('CREATE TEMPORARY TABLE __temp__route_train AS SELECT route_id, train_id FROM route_train');
        $this->addSql('DROP TABLE route_train');
        $this->addSql('CREATE TABLE route_train (route_id INTEGER NOT NULL, train_id INTEGER NOT NULL, PRIMARY KEY(route_id, train_id))');
        $this->addSql('INSERT INTO route_train (route_id, train_id) SELECT route_id, train_id FROM __temp__route_train');
        $this->addSql('DROP TABLE __temp__route_train');
        $this->addSql('CREATE INDEX IDX_C119D60D34ECB4E6 ON route_train (route_id)');
        $this->addSql('CREATE INDEX IDX_C119D60D23BCD4D0 ON route_train (train_id)');
    }
}
