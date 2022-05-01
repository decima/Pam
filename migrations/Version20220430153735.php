<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220430153735 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'create database';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE asset (id UUID NOT NULL, category_id UUID DEFAULT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, name VARCHAR(255) NOT NULL, path VARCHAR(1024) NOT NULL, signature VARCHAR(255) NOT NULL, size INT NOT NULL, import_origin VARCHAR(255) DEFAULT NULL, mimetype VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_2AF5A5CAE880141 ON asset (signature)');
        $this->addSql('CREATE INDEX IDX_2AF5A5C12469DE2 ON asset (category_id)');
        $this->addSql('COMMENT ON COLUMN asset.id IS \'(DC2Type:uuid)\'');
        $this->addSql('COMMENT ON COLUMN asset.category_id IS \'(DC2Type:uuid)\'');
        $this->addSql('COMMENT ON COLUMN asset.created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('CREATE TABLE asset_tag (asset_id UUID NOT NULL, tag_id UUID NOT NULL, PRIMARY KEY(asset_id, tag_id))');
        $this->addSql('CREATE INDEX IDX_6983740F5DA1941 ON asset_tag (asset_id)');
        $this->addSql('CREATE INDEX IDX_6983740FBAD26311 ON asset_tag (tag_id)');
        $this->addSql('COMMENT ON COLUMN asset_tag.asset_id IS \'(DC2Type:uuid)\'');
        $this->addSql('COMMENT ON COLUMN asset_tag.tag_id IS \'(DC2Type:uuid)\'');
        $this->addSql('CREATE TABLE category (id UUID NOT NULL, parent_id UUID DEFAULT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_64C19C1727ACA70 ON category (parent_id)');
        $this->addSql('COMMENT ON COLUMN category.id IS \'(DC2Type:uuid)\'');
        $this->addSql('COMMENT ON COLUMN category.parent_id IS \'(DC2Type:uuid)\'');
        $this->addSql('COMMENT ON COLUMN category.created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('CREATE TABLE category_tag (category_id UUID NOT NULL, tag_id UUID NOT NULL, PRIMARY KEY(category_id, tag_id))');
        $this->addSql('CREATE INDEX IDX_264B1AD912469DE2 ON category_tag (category_id)');
        $this->addSql('CREATE INDEX IDX_264B1AD9BAD26311 ON category_tag (tag_id)');
        $this->addSql('COMMENT ON COLUMN category_tag.category_id IS \'(DC2Type:uuid)\'');
        $this->addSql('COMMENT ON COLUMN category_tag.tag_id IS \'(DC2Type:uuid)\'');
        $this->addSql('CREATE TABLE tag (id UUID NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, name VARCHAR(255) NOT NULL, color VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('COMMENT ON COLUMN tag.id IS \'(DC2Type:uuid)\'');
        $this->addSql('COMMENT ON COLUMN tag.created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('ALTER TABLE asset ADD CONSTRAINT FK_2AF5A5C12469DE2 FOREIGN KEY (category_id) REFERENCES category (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE asset_tag ADD CONSTRAINT FK_6983740F5DA1941 FOREIGN KEY (asset_id) REFERENCES asset (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE asset_tag ADD CONSTRAINT FK_6983740FBAD26311 FOREIGN KEY (tag_id) REFERENCES tag (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE category ADD CONSTRAINT FK_64C19C1727ACA70 FOREIGN KEY (parent_id) REFERENCES category (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE category_tag ADD CONSTRAINT FK_264B1AD912469DE2 FOREIGN KEY (category_id) REFERENCES category (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE category_tag ADD CONSTRAINT FK_264B1AD9BAD26311 FOREIGN KEY (tag_id) REFERENCES tag (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE asset_tag DROP CONSTRAINT FK_6983740F5DA1941');
        $this->addSql('ALTER TABLE asset DROP CONSTRAINT FK_2AF5A5C12469DE2');
        $this->addSql('ALTER TABLE category DROP CONSTRAINT FK_64C19C1727ACA70');
        $this->addSql('ALTER TABLE category_tag DROP CONSTRAINT FK_264B1AD912469DE2');
        $this->addSql('ALTER TABLE asset_tag DROP CONSTRAINT FK_6983740FBAD26311');
        $this->addSql('ALTER TABLE category_tag DROP CONSTRAINT FK_264B1AD9BAD26311');
        $this->addSql('DROP TABLE asset');
        $this->addSql('DROP TABLE asset_tag');
        $this->addSql('DROP TABLE category');
        $this->addSql('DROP TABLE category_tag');
        $this->addSql('DROP TABLE tag');
    }
}
