<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20180718135052 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'sqlite', 'Migration can only be executed safely on \'sqlite\'.');

        $this->addSql('DROP INDEX idx_foto');
        $this->addSql('CREATE TEMPORARY TABLE __temp__foto AS SELECT pageid, title, timestamp, size, dimensions, author FROM foto');
        $this->addSql('DROP TABLE foto');
        $this->addSql('CREATE TABLE foto (pageid INTEGER NOT NULL, title VARCHAR(255) NOT NULL COLLATE BINARY, timestamp DATETIME NOT NULL, size INTEGER NOT NULL, dimensions VARCHAR(45) NOT NULL COLLATE BINARY, author VARCHAR(255) NOT NULL COLLATE BINARY, megapixels INTEGER DEFAULT NULL, PRIMARY KEY(pageid))');
        $this->addSql('INSERT INTO foto (pageid, title, timestamp, size, dimensions, author) SELECT pageid, title, timestamp, size, dimensions, author FROM __temp__foto');
        $this->addSql('DROP TABLE __temp__foto');
        $this->addSql('CREATE INDEX idx_foto ON foto (pageid)');
        $this->addSql('CREATE TEMPORARY TABLE __temp__users_commons AS SELECT id, username, date_create, is_new FROM users_commons');
        $this->addSql('DROP TABLE users_commons');
        $this->addSql('CREATE TABLE users_commons (id INTEGER NOT NULL, username VARCHAR(255) NOT NULL COLLATE BINARY, date_create DATETIME NOT NULL, is_new BOOLEAN NOT NULL, PRIMARY KEY(id))');
        $this->addSql('INSERT INTO users_commons (id, username, date_create, is_new) SELECT id, username, date_create, is_new FROM __temp__users_commons');
        $this->addSql('DROP TABLE __temp__users_commons');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'sqlite', 'Migration can only be executed safely on \'sqlite\'.');

        $this->addSql('DROP INDEX idx_foto');
        $this->addSql('CREATE TEMPORARY TABLE __temp__foto AS SELECT pageid, title, timestamp, size, dimensions, author FROM foto');
        $this->addSql('DROP TABLE foto');
        $this->addSql('CREATE TABLE foto (pageid INTEGER NOT NULL, title VARCHAR(255) NOT NULL, timestamp DATETIME NOT NULL, size INTEGER NOT NULL, dimensions VARCHAR(45) NOT NULL, author VARCHAR(255) NOT NULL, PRIMARY KEY(pageid))');
        $this->addSql('INSERT INTO foto (pageid, title, timestamp, size, dimensions, author) SELECT pageid, title, timestamp, size, dimensions, author FROM __temp__foto');
        $this->addSql('DROP TABLE __temp__foto');
        $this->addSql('CREATE INDEX idx_foto ON foto (pageid)');
        $this->addSql('CREATE TEMPORARY TABLE __temp__users_commons AS SELECT id, username, date_create, is_new FROM users_commons');
        $this->addSql('DROP TABLE users_commons');
        $this->addSql('CREATE TABLE users_commons (id INTEGER NOT NULL, username VARCHAR(255) NOT NULL, date_create DATETIME NOT NULL, is_new BOOLEAN DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('INSERT INTO users_commons (id, username, date_create, is_new) SELECT id, username, date_create, is_new FROM __temp__users_commons');
        $this->addSql('DROP TABLE __temp__users_commons');
    }
}
