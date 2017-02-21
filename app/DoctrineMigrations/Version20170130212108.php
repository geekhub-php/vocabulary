<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20170130212108 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE user_user (id INT AUTO_INCREMENT NOT NULL, wishlist_id INT DEFAULT NULL, login VARCHAR(100) NOT NULL, password VARCHAR(100) NOT NULL, role VARCHAR(50) NOT NULL, UNIQUE INDEX UNIQ_F7129A80AA08CB10 (login), UNIQUE INDEX UNIQ_F7129A80FB8E54CD (wishlist_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE wishlist_wishlist (id INT AUTO_INCREMENT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE wishlist_word (wishlist_id INT NOT NULL, word_id INT NOT NULL, INDEX IDX_B8CEA4E7FB8E54CD (wishlist_id), INDEX IDX_B8CEA4E7E357438D (word_id), PRIMARY KEY(wishlist_id, word_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE user_user ADD CONSTRAINT FK_F7129A80FB8E54CD FOREIGN KEY (wishlist_id) REFERENCES wishlist_wishlist (id)');
        $this->addSql('ALTER TABLE wishlist_word ADD CONSTRAINT FK_B8CEA4E7FB8E54CD FOREIGN KEY (wishlist_id) REFERENCES wishlist_wishlist (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE wishlist_word ADD CONSTRAINT FK_B8CEA4E7E357438D FOREIGN KEY (word_id) REFERENCES word_word (id) ON DELETE CASCADE');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE user_user DROP FOREIGN KEY FK_F7129A80FB8E54CD');
        $this->addSql('ALTER TABLE wishlist_word DROP FOREIGN KEY FK_B8CEA4E7FB8E54CD');
        $this->addSql('DROP TABLE user_user');
        $this->addSql('DROP TABLE wishlist_wishlist');
        $this->addSql('DROP TABLE wishlist_word');
    }
}
