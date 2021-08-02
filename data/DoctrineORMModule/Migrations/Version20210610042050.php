<?php declare(strict_types=1);

namespace DoctrineORMModule\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210610042050 extends AbstractMigration
{
    public function getDescription()
    {
        return 'Create oauth_scopes table.';
    }

    public function up(Schema $schema) : void
    {
        $table = $schema->createTable('oauth_scopes');

        $table->addColumn('id', 'integer', ['autoincrement' => true]);
        $table->addColumn('type', 'string', ['length' => 255, 'default' => 'supported']);
        $table->addColumn('scope', 'string', ['length' => 2000, 'notnull' => false]);
        $table->addColumn('client_id', 'string', ['length' => 80, 'notnull' => false]);
        $table->addColumn('is_default', 'smallint', ['notnull' => false]);

        $table->setPrimaryKey(['id']);
    }

    public function down(Schema $schema) : void
    {
        $schema->dropTable('oauth_scopes');
    }
}
