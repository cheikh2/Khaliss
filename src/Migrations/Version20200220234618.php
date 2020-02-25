<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200220234618 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE recu ADD contenu LONGTEXT DEFAULT NULL');
        $this->addSql('ALTER TABLE transaction ADD recus_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE transaction ADD CONSTRAINT FK_723705D1D012BDD FOREIGN KEY (recus_id) REFERENCES recu (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_723705D1D012BDD ON transaction (recus_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE recu DROP contenu');
        $this->addSql('ALTER TABLE transaction DROP FOREIGN KEY FK_723705D1D012BDD');
        $this->addSql('DROP INDEX UNIQ_723705D1D012BDD ON transaction');
        $this->addSql('ALTER TABLE transaction DROP recus_id');
    }
}
