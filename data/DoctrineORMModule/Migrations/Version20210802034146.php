<?php

declare(strict_types=1);

namespace DoctrineORMModule\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210802034146 extends AbstractMigration
{
    public function up(Schema $schema): void
    {
        $table = $schema->createTable('berita_konten');

        $table->addColumn('uuid', 'string', ['length' => 36]);
        $table->addColumn('judul', 'string', ['length' => 100]);
        $table->addColumn('isi', 'string', ['length' => 255]);
        $table->addColumn('penulis', 'string', ['length' => 100]);
        $table->addColumn('kategori', 'string', ['length' => 100]);
        $table->addColumn('created_at', 'datetime', ['default' => 'CURRENT_TIMESTAMP']);
        $table->addColumn('updated_at', 'datetime', ['default' => 'CURRENT_TIMESTAMP']);
        $table->addColumn('deleted_at', 'datetime', ['notnull' => false]);

        $table->setPrimaryKey(['uuid']);
    }

    public function down(Schema $schema): void
    {
        $schema->dropTable('berita_konten');
    }
}
