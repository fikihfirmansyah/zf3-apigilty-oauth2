<?php declare(strict_types=1);

namespace DoctrineORMModule\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210621031311 extends AbstractMigration
{
    public function getDescription()
    {
        return 'Create queue_logs table.';
    }

    public function up(Schema $schema) : void
    {
        $this->addSql(<<<SQL
            ALTER TABLE `queue_logs`
                ADD `processing_time` DOUBLE NULL DEFAULT NULL AFTER `end_time`,
                ADD `waiting_time` DOUBLE NULL DEFAULT NULL AFTER `processing_time`;
        SQL);
    }

    public function down(Schema $schema) : void
    {
        $this->addSql(<<<SQL
            ALTER TABLE `queue_logs`
                DROP `processing_time`,
                DROP `waiting_time`;
        SQL);
    }
}
