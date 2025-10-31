<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20251031084048 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE breed_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE breed (id INT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY (id))');
        $this->addSql('ALTER TABLE dog ADD breed_id INT NOT NULL');
        $this->addSql('ALTER TABLE dog DROP breed');
        $this->addSql('ALTER TABLE dog ADD CONSTRAINT FK_812C397DA8B4A30F FOREIGN KEY (breed_id) REFERENCES breed (id) NOT DEFERRABLE');
        $this->addSql('CREATE INDEX IDX_812C397DA8B4A30F ON dog (breed_id)');
        $this->addSql('ALTER INDEX uniq_8d93d649e7927c74 RENAME TO UNIQ_327C5DE7E7927C74');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP SEQUENCE breed_id_seq CASCADE');
        $this->addSql('DROP TABLE breed');
        $this->addSql('ALTER TABLE dog DROP CONSTRAINT FK_812C397DA8B4A30F');
        $this->addSql('DROP INDEX IDX_812C397DA8B4A30F');
        $this->addSql('ALTER TABLE dog ADD breed VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE dog DROP breed_id');
        $this->addSql('ALTER INDEX public.uniq_327c5de7e7927c74 RENAME TO uniq_8d93d649e7927c74');
    }
}
