<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210926095709 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE route (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, station_from_id INTEGER NOT NULL, station_to_id INTEGER NOT NULL, date_start DATETIME NOT NULL, date_end DATETIME NOT NULL, price DOUBLE PRECISION DEFAULT NULL)');
        $this->addSql('CREATE INDEX IDX_2C4207931687C55 ON route (station_from_id)');
        $this->addSql('CREATE INDEX IDX_2C4207968B33553 ON route (station_to_id)');
        $this->addSql('CREATE TABLE route_train (route_id INTEGER NOT NULL, train_id INTEGER NOT NULL, PRIMARY KEY(route_id, train_id))');
        $this->addSql('CREATE INDEX IDX_C119D60D34ECB4E6 ON route_train (route_id)');
        $this->addSql('CREATE INDEX IDX_C119D60D23BCD4D0 ON route_train (train_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE route');
        $this->addSql('DROP TABLE route_train');
    }
}
