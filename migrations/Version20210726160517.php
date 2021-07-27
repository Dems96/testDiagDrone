<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210726160517 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE admin CHANGE id_admin id_admin_id INT NOT NULL');
        $this->addSql('ALTER TABLE admin ADD CONSTRAINT FK_880E0D7634F06E85 FOREIGN KEY (id_admin_id) REFERENCES user (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_880E0D7634F06E85 ON admin (id_admin_id)');
        $this->addSql('ALTER TABLE conversation ADD id_utilisateur_id INT NOT NULL, ADD id_admin_id INT NOT NULL, DROP id_utilisateur, DROP id_admin');
        $this->addSql('ALTER TABLE conversation ADD CONSTRAINT FK_8A8E26E9C6EE5C49 FOREIGN KEY (id_utilisateur_id) REFERENCES utilisateur (id)');
        $this->addSql('ALTER TABLE conversation ADD CONSTRAINT FK_8A8E26E934F06E85 FOREIGN KEY (id_admin_id) REFERENCES admin (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8A8E26E9C6EE5C49 ON conversation (id_utilisateur_id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8A8E26E934F06E85 ON conversation (id_admin_id)');
        $this->addSql('ALTER TABLE message ADD id_conversation_id INT NOT NULL, ADD id_user_id INT NOT NULL, DROP id_conversation, DROP id_user, CHANGE id id INT AUTO_INCREMENT NOT NULL, CHANGE message message VARCHAR(255) NOT NULL, ADD PRIMARY KEY (id)');
        $this->addSql('ALTER TABLE message ADD CONSTRAINT FK_B6BD307FE0F2C01E FOREIGN KEY (id_conversation_id) REFERENCES conversation (id)');
        $this->addSql('ALTER TABLE message ADD CONSTRAINT FK_B6BD307F79F37AE5 FOREIGN KEY (id_user_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_B6BD307FE0F2C01E ON message (id_conversation_id)');
        $this->addSql('CREATE INDEX IDX_B6BD307F79F37AE5 ON message (id_user_id)');
        $this->addSql('ALTER TABLE user CHANGE roles roles VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE utilisateur CHANGE id_user id_user_id INT NOT NULL');
        $this->addSql('ALTER TABLE utilisateur ADD CONSTRAINT FK_1D1C63B379F37AE5 FOREIGN KEY (id_user_id) REFERENCES user (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_1D1C63B379F37AE5 ON utilisateur (id_user_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE admin DROP FOREIGN KEY FK_880E0D7634F06E85');
        $this->addSql('DROP INDEX UNIQ_880E0D7634F06E85 ON admin');
        $this->addSql('ALTER TABLE admin CHANGE id_admin_id id_admin INT NOT NULL');
        $this->addSql('ALTER TABLE conversation DROP FOREIGN KEY FK_8A8E26E9C6EE5C49');
        $this->addSql('ALTER TABLE conversation DROP FOREIGN KEY FK_8A8E26E934F06E85');
        $this->addSql('DROP INDEX UNIQ_8A8E26E9C6EE5C49 ON conversation');
        $this->addSql('DROP INDEX UNIQ_8A8E26E934F06E85 ON conversation');
        $this->addSql('ALTER TABLE conversation ADD id_utilisateur INT NOT NULL, ADD id_admin INT NOT NULL, DROP id_utilisateur_id, DROP id_admin_id');
        $this->addSql('ALTER TABLE message MODIFY id INT NOT NULL');
        $this->addSql('ALTER TABLE message DROP FOREIGN KEY FK_B6BD307FE0F2C01E');
        $this->addSql('ALTER TABLE message DROP FOREIGN KEY FK_B6BD307F79F37AE5');
        $this->addSql('DROP INDEX IDX_B6BD307FE0F2C01E ON message');
        $this->addSql('DROP INDEX IDX_B6BD307F79F37AE5 ON message');
        $this->addSql('ALTER TABLE message DROP PRIMARY KEY');
        $this->addSql('ALTER TABLE message ADD id_conversation INT NOT NULL, ADD id_user INT NOT NULL, DROP id_conversation_id, DROP id_user_id, CHANGE id id INT NOT NULL, CHANGE message message VARCHAR(255) CHARACTER SET latin1 DEFAULT NULL COLLATE `latin1_swedish_ci`');
        $this->addSql('ALTER TABLE user CHANGE roles roles VARCHAR(50) CHARACTER SET latin1 NOT NULL COLLATE `latin1_swedish_ci`');
        $this->addSql('ALTER TABLE utilisateur DROP FOREIGN KEY FK_1D1C63B379F37AE5');
        $this->addSql('DROP INDEX UNIQ_1D1C63B379F37AE5 ON utilisateur');
        $this->addSql('ALTER TABLE utilisateur CHANGE id_user_id id_user INT NOT NULL');
    }
}
