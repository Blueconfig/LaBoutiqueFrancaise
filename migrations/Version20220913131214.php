<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220913131214 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE blog_commentaire ADD article_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE blog_commentaire ADD CONSTRAINT FK_BEC0F4427294869C FOREIGN KEY (article_id) REFERENCES blog_article (id)');
        $this->addSql('CREATE INDEX IDX_BEC0F4427294869C ON blog_commentaire (article_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE blog_commentaire DROP FOREIGN KEY FK_BEC0F4427294869C');
        $this->addSql('DROP INDEX IDX_BEC0F4427294869C ON blog_commentaire');
        $this->addSql('ALTER TABLE blog_commentaire DROP article_id');
    }
}
