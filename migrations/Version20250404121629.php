<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250404121629 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            CREATE TABLE messages (id SERIAL NOT NULL, user_id INT NOT NULL, date TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, context TEXT NOT NULL, type BOOLEAN NOT NULL, PRIMARY KEY(id))
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_DB021E96A76ED395 ON messages (user_id)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE plans (id SERIAL NOT NULL, user_id INT NOT NULL, date DATE NOT NULL, dishes VARCHAR(255) NOT NULL, exercises VARCHAR(255) NOT NULL, PRIMARY KEY(id))
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_356798D1A76ED395 ON plans (user_id)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE users (id SERIAL NOT NULL, name VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, password VARCHAR(255) NOT NULL, yandex_id INT NOT NULL, gender VARCHAR(255) NOT NULL, physical_limitations VARCHAR(255) NOT NULL, level_of_training VARCHAR(255) NOT NULL, allergy TEXT DEFAULT NULL, inventory TEXT DEFAULT NULL, target VARCHAR(255) NOT NULL, PRIMARY KEY(id))
        SQL);
        $this->addSql(<<<'SQL'
            COMMENT ON COLUMN users.allergy IS '(DC2Type:simple_array)'
        SQL);
        $this->addSql(<<<'SQL'
            COMMENT ON COLUMN users.inventory IS '(DC2Type:simple_array)'
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE messages ADD CONSTRAINT FK_DB021E96A76ED395 FOREIGN KEY (user_id) REFERENCES users (id) NOT DEFERRABLE INITIALLY IMMEDIATE
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE plans ADD CONSTRAINT FK_356798D1A76ED395 FOREIGN KEY (user_id) REFERENCES users (id) NOT DEFERRABLE INITIALLY IMMEDIATE
        SQL);
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            CREATE SCHEMA public
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE messages DROP CONSTRAINT FK_DB021E96A76ED395
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE plans DROP CONSTRAINT FK_356798D1A76ED395
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE messages
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE plans
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE users
        SQL);
    }
}
