<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240617170907 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE url_code ADD user_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE url_code ADD CONSTRAINT FK_6941F920A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_6941F920A76ED395 ON url_code (user_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE url_code DROP FOREIGN KEY FK_6941F920A76ED395');
        $this->addSql('DROP INDEX IDX_6941F920A76ED395 ON url_code');
        $this->addSql('ALTER TABLE url_code DROP user_id');
    }
}
