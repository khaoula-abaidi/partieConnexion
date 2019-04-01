<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190401070933 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE contributor ADD decision_id INT NOT NULL');
        $this->addSql('ALTER TABLE contributor ADD CONSTRAINT FK_DA6F9793BDEE7539 FOREIGN KEY (decision_id) REFERENCES decision (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_DA6F9793BDEE7539 ON contributor (decision_id)');
        $this->addSql('ALTER TABLE structure DROP FOREIGN KEY FK_6F0137EACB94D64E');
        $this->addSql('DROP INDEX IDX_6F0137EACB94D64E ON structure');
        $this->addSql('ALTER TABLE structure DROP affiliation_id');
        $this->addSql('ALTER TABLE decision CHANGE is_taken is_taken TINYINT(1) DEFAULT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE contributor DROP FOREIGN KEY FK_DA6F9793BDEE7539');
        $this->addSql('DROP INDEX UNIQ_DA6F9793BDEE7539 ON contributor');
        $this->addSql('ALTER TABLE contributor DROP decision_id');
        $this->addSql('ALTER TABLE decision CHANGE is_taken is_taken TINYINT(1) NOT NULL');
        $this->addSql('ALTER TABLE structure ADD affiliation_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE structure ADD CONSTRAINT FK_6F0137EACB94D64E FOREIGN KEY (affiliation_id) REFERENCES structure (id)');
        $this->addSql('CREATE INDEX IDX_6F0137EACB94D64E ON structure (affiliation_id)');
    }
}
