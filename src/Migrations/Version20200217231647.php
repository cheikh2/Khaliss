<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200217231647 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE tarifs ADD transactions_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE tarifs ADD CONSTRAINT FK_F9B8C49677E1607F FOREIGN KEY (transactions_id) REFERENCES transaction (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_F9B8C49677E1607F ON tarifs (transactions_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE tarifs DROP FOREIGN KEY FK_F9B8C49677E1607F');
        $this->addSql('DROP INDEX UNIQ_F9B8C49677E1607F ON tarifs');
        $this->addSql('ALTER TABLE tarifs DROP transactions_id');
    }
}
