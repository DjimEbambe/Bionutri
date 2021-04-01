<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210324110105 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE blog_commentaire ADD blog_articles_id INT NOT NULL');
        $this->addSql('ALTER TABLE blog_commentaire ADD CONSTRAINT FK_BEC0F442C78A6A32 FOREIGN KEY (blog_articles_id) REFERENCES blog_articles (id)');
        $this->addSql('CREATE INDEX IDX_BEC0F442C78A6A32 ON blog_commentaire (blog_articles_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE blog_commentaire DROP FOREIGN KEY FK_BEC0F442C78A6A32');
        $this->addSql('DROP INDEX IDX_BEC0F442C78A6A32 ON blog_commentaire');
        $this->addSql('ALTER TABLE blog_commentaire DROP blog_articles_id');
    }
}
