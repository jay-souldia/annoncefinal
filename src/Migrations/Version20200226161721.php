<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200226161721 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE note DROP FOREIGN KEY FK_CFBDFA14A4677633');
        $this->addSql('ALTER TABLE note DROP FOREIGN KEY FK_CFBDFA14FB53BB69');
        $this->addSql('DROP INDEX IDX_CFBDFA14FB53BB69 ON note');
        $this->addSql('DROP INDEX IDX_CFBDFA14A4677633 ON note');
        $this->addSql('ALTER TABLE note ADD usernote_id INT NOT NULL, ADD usernotant_id INT NOT NULL, DROP user_noter_id, DROP user_notant_id');
        $this->addSql('ALTER TABLE note ADD CONSTRAINT FK_CFBDFA14BA8CF4EB FOREIGN KEY (usernote_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE note ADD CONSTRAINT FK_CFBDFA1435FE97ED FOREIGN KEY (usernotant_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_CFBDFA14BA8CF4EB ON note (usernote_id)');
        $this->addSql('CREATE INDEX IDX_CFBDFA1435FE97ED ON note (usernotant_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE note DROP FOREIGN KEY FK_CFBDFA14BA8CF4EB');
        $this->addSql('ALTER TABLE note DROP FOREIGN KEY FK_CFBDFA1435FE97ED');
        $this->addSql('DROP INDEX IDX_CFBDFA14BA8CF4EB ON note');
        $this->addSql('DROP INDEX IDX_CFBDFA1435FE97ED ON note');
        $this->addSql('ALTER TABLE note ADD user_noter_id INT NOT NULL, ADD user_notant_id INT NOT NULL, DROP usernote_id, DROP usernotant_id');
        $this->addSql('ALTER TABLE note ADD CONSTRAINT FK_CFBDFA14A4677633 FOREIGN KEY (user_noter_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE note ADD CONSTRAINT FK_CFBDFA14FB53BB69 FOREIGN KEY (user_notant_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_CFBDFA14FB53BB69 ON note (user_notant_id)');
        $this->addSql('CREATE INDEX IDX_CFBDFA14A4677633 ON note (user_noter_id)');
    }
}
