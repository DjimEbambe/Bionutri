<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210324112628 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE blog_articles_blog_mots_cles (blog_articles_id INT NOT NULL, blog_mots_cles_id INT NOT NULL, INDEX IDX_50DDC0E2C78A6A32 (blog_articles_id), INDEX IDX_50DDC0E29A626F5C (blog_mots_cles_id), PRIMARY KEY(blog_articles_id, blog_mots_cles_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE blog_articles_blog_category (blog_articles_id INT NOT NULL, blog_category_id INT NOT NULL, INDEX IDX_810BEFD2C78A6A32 (blog_articles_id), INDEX IDX_810BEFD2CB76011C (blog_category_id), PRIMARY KEY(blog_articles_id, blog_category_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE blog_articles_blog_mots_cles ADD CONSTRAINT FK_50DDC0E2C78A6A32 FOREIGN KEY (blog_articles_id) REFERENCES blog_articles (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE blog_articles_blog_mots_cles ADD CONSTRAINT FK_50DDC0E29A626F5C FOREIGN KEY (blog_mots_cles_id) REFERENCES blog_mots_cles (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE blog_articles_blog_category ADD CONSTRAINT FK_810BEFD2C78A6A32 FOREIGN KEY (blog_articles_id) REFERENCES blog_articles (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE blog_articles_blog_category ADD CONSTRAINT FK_810BEFD2CB76011C FOREIGN KEY (blog_category_id) REFERENCES blog_category (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE blog_articles_blog_mots_cles');
        $this->addSql('DROP TABLE blog_articles_blog_category');
    }
}
