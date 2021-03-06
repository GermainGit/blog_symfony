<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200211142940 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'sqlite', 'Migration can only be executed safely on \'sqlite\'.');

        $this->addSql('CREATE TABLE _user (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, username VARCHAR(255) NOT NULL, is_active BOOLEAN NOT NULL, is_blocked BOOLEAN NOT NULL)');
        $this->addSql('CREATE TEMPORARY TABLE __temp__post AS SELECT id, content, created_at, is_published, is_deleted, author_id, title FROM post');
        $this->addSql('DROP TABLE post');
        $this->addSql('CREATE TABLE post (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, content VARCHAR(1500) NOT NULL COLLATE BINARY, created_at DATETIME NOT NULL, is_published BOOLEAN NOT NULL, is_deleted BOOLEAN NOT NULL, author_id INTEGER NOT NULL, title VARCHAR(255) NOT NULL)');
        $this->addSql('INSERT INTO post (id, content, created_at, is_published, is_deleted, author_id, title) SELECT id, content, created_at, is_published, is_deleted, author_id, title FROM __temp__post');
        $this->addSql('DROP TABLE __temp__post');
        $this->addSql('CREATE TEMPORARY TABLE __temp__user AS SELECT id, username FROM user');
        $this->addSql('DROP TABLE user');
        $this->addSql('CREATE TABLE user (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, password VARCHAR(255) NOT NULL, email VARCHAR(180) NOT NULL DEFAULT "", roles CLOB NOT NULL --(DC2Type:json)
        )');
        $this->addSql('INSERT INTO user (id, password) SELECT id, username FROM __temp__user');
        $this->addSql('DROP TABLE __temp__user');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8D93D649E7927C74 ON user (email)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'sqlite', 'Migration can only be executed safely on \'sqlite\'.');

        $this->addSql('DROP TABLE _user');
        $this->addSql('CREATE TEMPORARY TABLE __temp__post AS SELECT id, content, created_at, is_published, is_deleted, title, author_id FROM post');
        $this->addSql('DROP TABLE post');
        $this->addSql('CREATE TABLE post (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, content VARCHAR(1500) NOT NULL, created_at DATETIME NOT NULL, is_published BOOLEAN NOT NULL, is_deleted BOOLEAN NOT NULL, author_id INTEGER NOT NULL, title VARCHAR(255) DEFAULT \'""\' NOT NULL COLLATE BINARY)');
        $this->addSql('INSERT INTO post (id, content, created_at, is_published, is_deleted, title, author_id) SELECT id, content, created_at, is_published, is_deleted, title, author_id FROM __temp__post');
        $this->addSql('DROP TABLE __temp__post');
        $this->addSql('DROP INDEX UNIQ_8D93D649E7927C74');
        $this->addSql('CREATE TEMPORARY TABLE __temp__user AS SELECT id, password FROM user');
        $this->addSql('DROP TABLE user');
        $this->addSql('CREATE TABLE user (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, username VARCHAR(255) NOT NULL COLLATE BINARY, is_active BOOLEAN NOT NULL, is_blocked BOOLEAN NOT NULL)');
        $this->addSql('INSERT INTO user (id, username) SELECT id, password FROM __temp__user');
        $this->addSql('DROP TABLE __temp__user');
    }
}
