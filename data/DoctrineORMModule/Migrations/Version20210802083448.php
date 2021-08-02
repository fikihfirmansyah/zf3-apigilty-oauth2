<?php

declare(strict_types=1);

namespace DoctrineORMModule\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210802083448 extends AbstractMigration
{
    public function up(Schema $schema): void
    {
        $table = $schema->createTable('berita_comments');

        $table->addColumn('uuid', 'string', ['length' => 36]);
        $table->addColumn('konten_uuid', 'string', ['length' => 36]);
        $table->addColumn('comments', 'string', ['length' => 100]);
        $table->addColumn('authors', 'string', ['length' => 100]);
        $table->addColumn('created_at', 'datetime', ['default' => 'CURRENT_TIMESTAMP']);
        $table->addColumn('updated_at', 'datetime', ['default' => 'CURRENT_TIMESTAMP']);
        $table->addColumn('deleted_at', 'datetime', ['notnull' => false]);

        $table->setPrimaryKey(['uuid']);
        $table->addIndex(['konten_uuid'], 'konten_idx');

        $table->addForeignKeyConstraint(
            'berita_konten',
            ['konten_uuid'],
            ['uuid'],
            ['onUpdate' => 'CASCADE'],
        );
    }

    public function down(Schema $schema): void
    {
        $schema->dropTable('berita_comments');
    }
}
