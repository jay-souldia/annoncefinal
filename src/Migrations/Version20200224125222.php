<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200224125222 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE annonce ADD user_id INT NOT NULL, ADD photo_id INT NOT NULL, ADD categorie_id INT NOT NULL');
        $this->addSql('ALTER TABLE annonce ADD CONSTRAINT FK_F65593E5A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE annonce ADD CONSTRAINT FK_F65593E57E9E4C8C FOREIGN KEY (photo_id) REFERENCES photo (id)');
        $this->addSql('ALTER TABLE annonce ADD CONSTRAINT FK_F65593E5BCF5E72D FOREIGN KEY (categorie_id) REFERENCES categorie (id)');
        $this->addSql('CREATE INDEX IDX_F65593E5A76ED395 ON annonce (user_id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_F65593E57E9E4C8C ON annonce (photo_id)');
        $this->addSql('CREATE INDEX IDX_F65593E5BCF5E72D ON annonce (categorie_id)');
        $this->addSql('ALTER TABLE commentaire ADD user_id INT NOT NULL, ADD annonce_id INT NOT NULL');
        $this->addSql('ALTER TABLE commentaire ADD CONSTRAINT FK_67F068BCA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE commentaire ADD CONSTRAINT FK_67F068BC8805AB2F FOREIGN KEY (annonce_id) REFERENCES annonce (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_67F068BCA76ED395 ON commentaire (user_id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_67F068BC8805AB2F ON commentaire (annonce_id)');
        $this->addSql('ALTER TABLE note ADD user_noter_id INT NOT NULL, ADD user_notant_id INT NOT NULL');
        $this->addSql('ALTER TABLE note ADD CONSTRAINT FK_CFBDFA14A4677633 FOREIGN KEY (user_noter_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE note ADD CONSTRAINT FK_CFBDFA14FB53BB69 FOREIGN KEY (user_notant_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_CFBDFA14A4677633 ON note (user_noter_id)');
        $this->addSql('CREATE INDEX IDX_CFBDFA14FB53BB69 ON note (user_notant_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE annonce DROP FOREIGN KEY FK_F65593E5A76ED395');
        $this->addSql('ALTER TABLE annonce DROP FOREIGN KEY FK_F65593E57E9E4C8C');
        $this->addSql('ALTER TABLE annonce DROP FOREIGN KEY FK_F65593E5BCF5E72D');
        $this->addSql('DROP INDEX IDX_F65593E5A76ED395 ON annonce');
        $this->addSql('DROP INDEX UNIQ_F65593E57E9E4C8C ON annonce');
        $this->addSql('DROP INDEX IDX_F65593E5BCF5E72D ON annonce');
        $this->addSql('ALTER TABLE annonce DROP user_id, DROP photo_id, DROP categorie_id');
        $this->addSql('ALTER TABLE commentaire DROP FOREIGN KEY FK_67F068BCA76ED395');
        $this->addSql('ALTER TABLE commentaire DROP FOREIGN KEY FK_67F068BC8805AB2F');
        $this->addSql('DROP INDEX UNIQ_67F068BCA76ED395 ON commentaire');
        $this->addSql('DROP INDEX UNIQ_67F068BC8805AB2F ON commentaire');
        $this->addSql('ALTER TABLE commentaire DROP user_id, DROP annonce_id');
        $this->addSql('ALTER TABLE note DROP FOREIGN KEY FK_CFBDFA14A4677633');
        $this->addSql('ALTER TABLE note DROP FOREIGN KEY FK_CFBDFA14FB53BB69');
        $this->addSql('DROP INDEX IDX_CFBDFA14A4677633 ON note');
        $this->addSql('DROP INDEX IDX_CFBDFA14FB53BB69 ON note');
        $this->addSql('ALTER TABLE note DROP user_noter_id, DROP user_notant_id');
    }
}
