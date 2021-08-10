<?php

declare(strict_types=1);

namespace DoctrineORMModule\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210808200531 extends AbstractMigration
{
    public function up(Schema $schema): void
    {
        $table = $schema->createTable('forum_reply_nested');

        $table->addColumn('uuid', 'string', ['length' => 255]);
        $table->addColumn('reply_uuid', 'string', ['length' => 255]);
        $table->addColumn('reply_nested_body', 'string', ['length' => 255]);
        $table->addColumn('reply_nested_author', 'string', ['length' => 255]);
        $table->addColumn('reply_nested_attach', 'text');
        $table->addColumn('created_at', 'datetime', ['default' => 'CURRENT_TIMESTAMP']);
        $table->addColumn('updated_at', 'datetime', ['default' => 'CURRENT_TIMESTAMP']);
        $table->addColumn('deleted_at', 'datetime', ['notnull' => false]);

        $table->setPrimaryKey(['uuid']);
        $table->addIndex(['reply_uuid'], 'reply_idx');

        $table->addForeignKeyConstraint(
            'forum_reply',
            ['reply_uuid'],
            ['uuid'],
            ['onUpdate' => 'CASCADE']
        );
    }

    public function down(Schema $schema): void
    {
        $schema->dropTable('forum_reply_nested');
    }
}
