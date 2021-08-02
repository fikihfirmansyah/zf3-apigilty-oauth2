<?php declare(strict_types=1);

namespace DoctrineORMModule\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210611023533 extends AbstractMigration
{
    public function getDescription()
    {
        'Create queue_sites table.';
    }

    public function up(Schema $schema) : void
    {
        $table = $schema->createTable('queue_sites');

        $table->addColumn('uuid', 'string', ['length' => 36]);
        $table->addColumn('name', 'string', ['length' => 100]);
        $table->addColumn('description', 'string', ['length' => 255, 'notnull' => false]);
        $table->addColumn('created_at', 'datetime', ['default' => 'CURRENT_TIMESTAMP']);
        $table->addColumn('updated_at', 'datetime', ['default' => 'CURRENT_TIMESTAMP']);
        $table->addColumn('deleted_at', 'datetime', ['notnull' => false]);

        $table->setPrimaryKey(['uuid']);
    }

    public function down(Schema $schema) : void
    {
        $schema->dropTable('queue_sites');
    }
}
