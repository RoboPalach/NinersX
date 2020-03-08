<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200308174856 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE shop_item (id INT AUTO_INCREMENT NOT NULL, preview_image_id INT DEFAULT NULL, author_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, description LONGTEXT NOT NULL, INDEX IDX_DEE9C365FAE957CD (preview_image_id), INDEX IDX_DEE9C365F675F31B (author_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE shop_item_image (shop_item_id INT NOT NULL, image_id INT NOT NULL, INDEX IDX_95E9F2A9115C1274 (shop_item_id), INDEX IDX_95E9F2A93DA5256D (image_id), PRIMARY KEY(shop_item_id, image_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE shop_item_user (shop_item_id INT NOT NULL, user_id INT NOT NULL, INDEX IDX_5C141C39115C1274 (shop_item_id), INDEX IDX_5C141C39A76ED395 (user_id), PRIMARY KEY(shop_item_id, user_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE shop_item_chapter (shop_item_id INT NOT NULL, chapter_id INT NOT NULL, INDEX IDX_EFB9F4E8115C1274 (shop_item_id), INDEX IDX_EFB9F4E8579F4768 (chapter_id), PRIMARY KEY(shop_item_id, chapter_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE shop_item ADD CONSTRAINT FK_DEE9C365FAE957CD FOREIGN KEY (preview_image_id) REFERENCES image (id)');
        $this->addSql('ALTER TABLE shop_item ADD CONSTRAINT FK_DEE9C365F675F31B FOREIGN KEY (author_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE shop_item_image ADD CONSTRAINT FK_95E9F2A9115C1274 FOREIGN KEY (shop_item_id) REFERENCES shop_item (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE shop_item_image ADD CONSTRAINT FK_95E9F2A93DA5256D FOREIGN KEY (image_id) REFERENCES image (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE shop_item_user ADD CONSTRAINT FK_5C141C39115C1274 FOREIGN KEY (shop_item_id) REFERENCES shop_item (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE shop_item_user ADD CONSTRAINT FK_5C141C39A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE shop_item_chapter ADD CONSTRAINT FK_EFB9F4E8115C1274 FOREIGN KEY (shop_item_id) REFERENCES shop_item (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE shop_item_chapter ADD CONSTRAINT FK_EFB9F4E8579F4768 FOREIGN KEY (chapter_id) REFERENCES chapter (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE shop_item_image DROP FOREIGN KEY FK_95E9F2A9115C1274');
        $this->addSql('ALTER TABLE shop_item_user DROP FOREIGN KEY FK_5C141C39115C1274');
        $this->addSql('ALTER TABLE shop_item_chapter DROP FOREIGN KEY FK_EFB9F4E8115C1274');
        $this->addSql('DROP TABLE shop_item');
        $this->addSql('DROP TABLE shop_item_image');
        $this->addSql('DROP TABLE shop_item_user');
        $this->addSql('DROP TABLE shop_item_chapter');
    }
}
