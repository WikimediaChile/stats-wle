<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20180622192418 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'sqlite', 'Migration can only be executed safely on \'sqlite\'.');

        $this->addSql('CREATE TEMPORARY TABLE __temp__foto AS SELECT id, pageid, title, timestamp, author FROM foto');
        $this->addSql('DROP TABLE foto');
        $this->addSql('CREATE TABLE foto (id INTEGER NOT NULL, pageid INTEGER NOT NULL, title VARCHAR(255) NOT NULL COLLATE BINARY, timestamp DATETIME NOT NULL, author VARCHAR(255) NOT NULL COLLATE BINARY, PRIMARY KEY(id))');
        $this->addSql('INSERT INTO foto (id, pageid, title, timestamp, author) SELECT id, pageid, title, timestamp, author FROM __temp__foto');
        $this->addSql('DROP TABLE __temp__foto');
        $this->addSql('CREATE INDEX idx_foto ON foto (pageid)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'sqlite', 'Migration can only be executed safely on \'sqlite\'.');

        $this->addSql('DROP INDEX idx_foto');
        $this->addSql('CREATE TEMPORARY TABLE __temp__foto AS SELECT id, pageid, title, timestamp, author FROM foto');
        $this->addSql('DROP TABLE foto');
        $this->addSql('CREATE TABLE foto (id INTEGER NOT NULL, pageid INTEGER NOT NULL, title VARCHAR(255) NOT NULL, timestamp DATETIME NOT NULL, author VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('INSERT INTO foto (id, pageid, title, timestamp, author) SELECT id, pageid, title, timestamp, author FROM __temp__foto');
        $this->addSql('DROP TABLE __temp__foto');
    }
}
