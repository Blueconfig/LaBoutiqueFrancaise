<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220912124235 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE blog_article (id INT AUTO_INCREMENT NOT NULL, editor_id INT DEFAULT NULL, title VARCHAR(150) NOT NULL, slug VARCHAR(180) NOT NULL, content LONGTEXT NOT NULL, created_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_EECCB3E56995AC4C (editor_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE blog_article_blog_categorie (blog_article_id INT NOT NULL, blog_categorie_id INT NOT NULL, INDEX IDX_7D793B1B9452A475 (blog_article_id), INDEX IDX_7D793B1BE62908AA (blog_categorie_id), PRIMARY KEY(blog_article_id, blog_categorie_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE blog_categorie (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(150) NOT NULL, slug VARCHAR(180) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE blog_images (id INT AUTO_INCREMENT NOT NULL, blog_article_id INT DEFAULT NULL, title VARCHAR(150) DEFAULT NULL, file VARCHAR(255) DEFAULT NULL, created_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_75501BAB9452A475 (blog_article_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE blog_article ADD CONSTRAINT FK_EECCB3E56995AC4C FOREIGN KEY (editor_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE blog_article_blog_categorie ADD CONSTRAINT FK_7D793B1B9452A475 FOREIGN KEY (blog_article_id) REFERENCES blog_article (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE blog_article_blog_categorie ADD CONSTRAINT FK_7D793B1BE62908AA FOREIGN KEY (blog_categorie_id) REFERENCES blog_categorie (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE blog_images ADD CONSTRAINT FK_75501BAB9452A475 FOREIGN KEY (blog_article_id) REFERENCES blog_article (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE blog_article DROP FOREIGN KEY FK_EECCB3E56995AC4C');
        $this->addSql('ALTER TABLE blog_article_blog_categorie DROP FOREIGN KEY FK_7D793B1B9452A475');
        $this->addSql('ALTER TABLE blog_article_blog_categorie DROP FOREIGN KEY FK_7D793B1BE62908AA');
        $this->addSql('ALTER TABLE blog_images DROP FOREIGN KEY FK_75501BAB9452A475');
        $this->addSql('DROP TABLE blog_article');
        $this->addSql('DROP TABLE blog_article_blog_categorie');
        $this->addSql('DROP TABLE blog_categorie');
        $this->addSql('DROP TABLE blog_images');
    }
}
