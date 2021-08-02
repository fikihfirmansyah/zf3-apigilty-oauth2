<?php declare(strict_types=1);

namespace DoctrineORMModule\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210611024244 extends AbstractMigration
{
    public function getDescription()
    {
        return 'Create queue_devices table.';
    }

    public function up(Schema $schema) : void
    {
        $table = $schema->createTable('queue_devices');

        $table->addColumn('uuid', 'string', ['length' => 36]);
        $table->addColumn('site_uuid', 'string', ['length' => 36]);
        $table->addColumn('name', 'string', ['length' => 100]);
        $table->addColumn('description', 'string', ['length' => 255, 'notnull' => false]);
        $table->addColumn('created_at', 'datetime', ['default' => 'CURRENT_TIMESTAMP']);
        $table->addColumn('updated_at', 'datetime', ['default' => 'CURRENT_TIMESTAMP']);
        $table->addColumn('deleted_at', 'datetime', ['notnull' => false]);

        $table->setPrimaryKey(['uuid']);
        $table->addIndex(['site_uuid'], 'queue_device_site_idx');

        $table->addForeignKeyConstraint(
            'queue_sites',
            ['site_uuid'],
            ['uuid'],
            ['onUpdate' => 'CASCADE'],
            'queue_device_sites_fk'
        );
    }

    public function down(Schema $schema) : void
    {
        $schema->dropTable('queue_devices');
    }
}
