<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210922061800 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE calendar (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, student_id INTEGER DEFAULT NULL, title VARCHAR(255) NOT NULL, content CLOB NOT NULL, start DATETIME NOT NULL, "end" DATETIME NOT NULL, all_day BOOLEAN NOT NULL, background_color VARCHAR(7) NOT NULL, border_color VARCHAR(7) NOT NULL, text_color VARCHAR(7) NOT NULL, validate BOOLEAN DEFAULT NULL)');
        $this->addSql('CREATE INDEX IDX_6EA9A146CB944F1A ON calendar (student_id)');
        $this->addSql('CREATE TABLE email_template (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, name VARCHAR(255) NOT NULL, content CLOB NOT NULL)');
        $this->addSql('CREATE TABLE mentor (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, firstname VARCHAR(255) NOT NULL, lastname VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, visiolink VARCHAR(255) NOT NULL, discordlink VARCHAR(255) NOT NULL, workplacelink VARCHAR(255) NOT NULL, logo VARCHAR(255) NOT NULL)');
        $this->addSql('CREATE TABLE path (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, category_id INTEGER NOT NULL, certificate_id INTEGER NOT NULL, name VARCHAR(255) NOT NULL, slug VARCHAR(255) NOT NULL, color VARCHAR(255) NOT NULL, time INTEGER NOT NULL)');
        $this->addSql('CREATE INDEX IDX_B548B0F12469DE2 ON path (category_id)');
        $this->addSql('CREATE INDEX IDX_B548B0F99223FFD ON path (certificate_id)');
        $this->addSql('CREATE TABLE path_category (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, name VARCHAR(255) NOT NULL, slug VARCHAR(255) NOT NULL, color VARCHAR(255) NOT NULL)');
        $this->addSql('CREATE TABLE path_certificate (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, name VARCHAR(255) NOT NULL, level VARCHAR(255) NOT NULL)');
        $this->addSql('CREATE TABLE path_project (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, path_id INTEGER DEFAULT NULL, name VARCHAR(255) NOT NULL, link VARCHAR(255) NOT NULL, time INTEGER NOT NULL, renumerate DOUBLE PRECISION NOT NULL)');
        $this->addSql('CREATE INDEX IDX_E805E6C7D96C566B ON path_project (path_id)');
        $this->addSql('CREATE TABLE student (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, path_id INTEGER DEFAULT NULL, project_id INTEGER DEFAULT NULL, firstname VARCHAR(255) NOT NULL, lastname VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, student_progress INTEGER NOT NULL, last_appointment DATETIME DEFAULT NULL, next_appointment DATETIME DEFAULT NULL)');
        $this->addSql('CREATE INDEX IDX_B723AF33D96C566B ON student (path_id)');
        $this->addSql('CREATE INDEX IDX_B723AF33166D1F9C ON student (project_id)');
        $this->addSql('CREATE INDEX IDX_B723AF3383A00E683124B5B6E7927C74 ON student (firstname, lastname, email)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE calendar');
        $this->addSql('DROP TABLE email_template');
        $this->addSql('DROP TABLE mentor');
        $this->addSql('DROP TABLE path');
        $this->addSql('DROP TABLE path_category');
        $this->addSql('DROP TABLE path_certificate');
        $this->addSql('DROP TABLE path_project');
        $this->addSql('DROP TABLE student');
    }
}
