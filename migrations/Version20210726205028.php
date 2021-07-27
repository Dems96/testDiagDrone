<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210726205028 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE admin CHANGE conversation_id conversation_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE admin ADD CONSTRAINT FK_880E0D769AC0396 FOREIGN KEY (conversation_id) REFERENCES conversation (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_880E0D769AC0396 ON admin (conversation_id)');
        $this->addSql('ALTER TABLE conversation DROP INDEX UNIQ_8A8E26E934F06E85, ADD INDEX IDX_8A8E26E934F06E85 (id_admin_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE admin DROP FOREIGN KEY FK_880E0D769AC0396');
        $this->addSql('DROP INDEX UNIQ_880E0D769AC0396 ON admin');
        $this->addSql('ALTER TABLE admin CHANGE conversation_id conversation_id INT NOT NULL');
        $this->addSql('ALTER TABLE conversation DROP INDEX IDX_8A8E26E934F06E85, ADD UNIQUE INDEX UNIQ_8A8E26E934F06E85 (id_admin_id)');
    }
}
