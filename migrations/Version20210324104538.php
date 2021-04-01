<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210324104538 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE blog_articles ADD users_id INT NOT NULL');
        $this->addSql('ALTER TABLE blog_articles ADD CONSTRAINT FK_CB80154F67B3B43D FOREIGN KEY (users_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_CB80154F67B3B43D ON blog_articles (users_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE blog_articles DROP FOREIGN KEY FK_CB80154F67B3B43D');
        $this->addSql('DROP INDEX IDX_CB80154F67B3B43D ON blog_articles');
        $this->addSql('ALTER TABLE blog_articles DROP users_id');
    }
}
