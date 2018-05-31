<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20180530145740 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, username VARCHAR(20) NOT NULL, first_name VARCHAR(20) DEFAULT NULL, last_name VARCHAR(20) DEFAULT NULL, password VARCHAR(255) NOT NULL, last_login DATETIME DEFAULT NULL, create_at DATETIME NOT NULL, roles LONGTEXT NOT NULL COMMENT \'(DC2Type:array)\', is_active TINYINT(1) NOT NULL, email VARCHAR(255) DEFAULT NULL, UNIQUE INDEX UNIQ_8D93D649F85E0677 (username), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE book CHANGE kind type VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE author ADD last_name VARCHAR(255) NOT NULL, ADD first_name VARCHAR(255) NOT NULL, DROP name, DROP firstname, CHANGE birthdate birth_date DATETIME NOT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE user');
        $this->addSql('ALTER TABLE author ADD name VARCHAR(255) NOT NULL COLLATE utf8mb4_unicode_ci, ADD firstname VARCHAR(255) NOT NULL COLLATE utf8mb4_unicode_ci, DROP last_name, DROP first_name, CHANGE birth_date birthdate DATETIME NOT NULL');
        $this->addSql('ALTER TABLE book CHANGE type kind VARCHAR(255) NOT NULL COLLATE utf8mb4_unicode_ci');
    }
}
