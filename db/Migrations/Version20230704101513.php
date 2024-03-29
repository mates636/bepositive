<?php

declare(strict_types=1);

namespace Database\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230704101513 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->skipIf(
            !$this->connection->getDatabasePlatform() instanceof \Doctrine\DBAL\Platforms\PostgreSQL100Platform,
            "Migration can only be executed safely on '\Doctrine\DBAL\Platforms\PostgreSQL100Platform'."
        );

        $this->addSql('CREATE SEQUENCE "customer_id_seq" INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE "customer" (id INT NOT NULL, firstname VARCHAR(255) NOT NULL, lastname VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, telephone VARCHAR(255) NOT NULL, last_logged_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_CUSTOMERE ON "customer" (email)');
        // $this->addSql('CREATE UNIQUE INDEX UNIQ_CUSTOMERL ON "customer" (lastname)');

        $this->addSql('CREATE SEQUENCE "product_id_seq" INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE "product" (id INT NOT NULL, name VARCHAR(255) NOT NULL, value VARCHAR(255) NOT NULL, stockdesign VARCHAR(255) NOT NULL, last_logged_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL,created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_PRODUCTE ON "product" (name)');

        $this->addSql('CREATE SEQUENCE "order_id_seq" INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE "order" (id INT NOT NULL,productid VARCHAR(255) NOT NULL,customerid VARCHAR(255) NOT NULL, orderstate VARCHAR(255) NOT NULL, price VARCHAR(255) NOT NULL, last_logged_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL,created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, PRIMARY KEY(id))');



        $this->addSql('CREATE SEQUENCE "user_id_seq" INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE "user" (id INT NOT NULL, name VARCHAR(255) NOT NULL, surname VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, username VARCHAR(255) NOT NULL, state INT NOT NULL, password VARCHAR(255) NOT NULL, role VARCHAR(255) NOT NULL, apikey VARCHAR(255) NOT NULL, last_logged_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8D93D649E7927C74 ON "user" (email)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8D93D649F85E0677 ON "user" (username)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->skipIf(
            !$this->connection->getDatabasePlatform() instanceof \Doctrine\DBAL\Platforms\PostgreSQL100Platform,
            "Migration can only be executed safely on '\Doctrine\DBAL\Platforms\PostgreSQL100Platform'."
        );

        $this->addSql('CREATE SCHEMA public');

        $this->addSql('DROP SEQUENCE "user_id_seq" CASCADE');
        $this->addSql('DROP TABLE "user"');

        $this->addSql('DROP SEQUENCE "customer_id_seq" CASCADE');
        $this->addSql('DROP TABLE "customer"');

    }
}
