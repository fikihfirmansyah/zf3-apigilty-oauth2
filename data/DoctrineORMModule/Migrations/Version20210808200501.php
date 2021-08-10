<?php

declare(strict_types=1);

namespace DoctrineORMModule\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210808200501 extends AbstractMigration
{
    public function up(Schema $schema): void
    {
        $table = $schema->createTable('forum_reply');

        $table->addColumn('uuid', 'string', ['length' => 255]);
        $table->addColumn('thread_uuid', 'string', ['length' => 255]);
        $table->addColumn('reply_body', 'string', ['length' => 255]);
        $table->addColumn('reply_author', 'string', ['length' => 255]);
        $table->addColumn('reply_attach', 'text');
        $table->addColumn('created_at', 'datetime', ['default' => 'CURRENT_TIMESTAMP']);
        $table->addColumn('updated_at', 'datetime', ['default' => 'CURRENT_TIMESTAMP']);
        $table->addColumn('deleted_at', 'datetime', ['notnull' => false]);

        $table->setPrimaryKey(['uuid']);
        $table->addIndex(['thread_uuid'], 'thread_idx');

        $table->addForeignKeyConstraint(
            'forum_thread',
            ['thread_uuid'],
            ['uuid'],
            ['onUpdate' => 'CASCADE']
        );
    }

    public function down(Schema $schema): void
    {
        $schema->dropTable('forum_reply');
    }
}
