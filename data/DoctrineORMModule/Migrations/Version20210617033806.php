<?php declare(strict_types=1);

namespace DoctrineORMModule\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210617033806 extends AbstractMigration
{
    public function getDescription()
    {
        return 'Create queue_log_daily_summaries table.';
    }

    public function up(Schema $schema) : void
    {
        $table = $schema->createTable('queue_log_daily_summaries');

        $table->addColumn('uuid', 'string', ['length' => 36]);
        $table->addColumn('device_uuid', 'string', ['length' => 36]);
        $table->addColumn('counter_number', 'string', ['length' => 50]);
        $table->addColumn('date', 'date', []);
        $table->addColumn('total_queue', 'integer', ['default' => 0]);
        $table->addColumn('avg_processing_time', 'float', ['default' => 0]);
        $table->addColumn('avg_waiting_time', 'float', ['default' => 0]);
        $table->addColumn('created_at', 'datetime', ['default' => 'CURRENT_TIMESTAMP']);
        $table->addColumn('updated_at', 'datetime', ['default' => 'CURRENT_TIMESTAMP']);
        $table->addColumn('deleted_at', 'datetime', ['notnull' => false]);

        $table->setPrimaryKey(['uuid']);
        $table->addIndex(['device_uuid'], 'daily_summary_device_idx');
        $table->addIndex(['counter_number'], 'daily_summary_counter_idx');
        $table->addIndex(['date'], 'daily_summary_date_idx');

        $table->addForeignKeyConstraint(
            'queue_devices',
            ['device_uuid'],
            ['uuid'],
            ['onUpdate' => 'CASCADE'],
            'daily_summary_device_fk'
        );
    }

    public function down(Schema $schema) : void
    {
        $schema->dropTable('queue_log_daily_summaries');
    }
}
