<?php declare(strict_types=1);

namespace DoctrineORMModule\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210611024405 extends AbstractMigration
{
    public function getDescription()
    {
        return 'Create queue_logs table.';
    }

    public function up(Schema $schema) : void
    {
        $table = $schema->createTable('queue_logs');

        $table->addColumn('uuid', 'string', ['length' => 36]);
        $table->addColumn('device_uuid', 'string', ['length' => 50]);
        $table->addColumn('number', 'string', ['length' => 50]);
        $table->addColumn('counter_number', 'string', ['length' => 50]);
        $table->addColumn('reserved_time', 'datetime', []);
        $table->addColumn('called_time', 'datetime', ['notnull' => false]);
        $table->addColumn('end_time', 'datetime', ['notnull' => false]);
        $table->addColumn('created_at', 'datetime', ['default' => 'CURRENT_TIMESTAMP']);
        $table->addColumn('updated_at', 'datetime', ['default' => 'CURRENT_TIMESTAMP']);
        $table->addColumn('deleted_at', 'datetime', ['notnull' => false]);

        $table->setPrimaryKey(['uuid']);
        $table->addIndex(['device_uuid'], 'queue_log_device_idx');
        $table->addIndex(['number'], 'queue_log_number_idx');
        $table->addIndex(['counter_number'], 'queue_log_counter_number_idx');
        $table->addIndex(['reserved_time'], 'queue_log_reserved_time_idx');

        $table->addForeignKeyConstraint(
            'queue_devices',
            ['device_uuid'],
            ['uuid'],
            ['onUpdate' => 'CASCADE'],
            'queue_log_device_fk'
        );
    }

    public function down(Schema $schema) : void
    {
        $schema->dropTable('queue_logs');
    }
}
