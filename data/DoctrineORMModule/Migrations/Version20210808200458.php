<?php

declare(strict_types=1);

namespace DoctrineORMModule\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210808200458 extends AbstractMigration
{
    public function up(Schema $schema): void
    {
        $table = $schema->createTable('forum_thread');

        $table->addColumn('uuid', 'string', ['length' => 255]);
        $table->addColumn('thread_title', 'string', ['length' => 255]);
        $table->addColumn('thread_body', 'string', ['length' => 255]);
        $table->addColumn('thread_tags', 'string', ['length' => 255]);
        $table->addColumn('thread_author', 'string', ['length' => 255]);
        $table->addColumn('thread_attach', 'text');
        $table->addColumn('thread_category', 'string', ['length' => 255]);
        $table->addColumn('created_at', 'datetime', ['default' => 'CURRENT_TIMESTAMP']);
        $table->addColumn('updated_at', 'datetime', ['default' => 'CURRENT_TIMESTAMP']);
        $table->addColumn('deleted_at', 'datetime', ['notnull' => false]);

        $table->setPrimaryKey(['uuid']);
    }

    public function down(Schema $schema): void
    {
        $schema->dropTable('forum_thread');
    }
}
