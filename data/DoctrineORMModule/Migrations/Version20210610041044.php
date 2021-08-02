<?php declare(strict_types=1);

namespace DoctrineORMModule\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210610041044 extends AbstractMigration
{
    public function getDescription()
    {
        return 'Create authorization_codes table.';
    }

    public function up(Schema $schema) : void
    {
        $table = $schema->createTable('authorization_codes');

        $table->addColumn('authorization_code', 'string', ['length' => 80]);
        $table->addColumn('client_id', 'string', ['length' => 80]);
        $table->addColumn('user_id', 'string', ['length' => 255, 'notnull' => false]);
        $table->addColumn('redirect_uri', 'string', ['length' => 2000, 'notnull' => false]);
        $table->addColumn('expires', 'datetime', ['default' => 'CURRENT_TIMESTAMP']);
        $table->addColumn('scope', 'string', ['length' => 2000, 'notnull' => false]);
        $table->addColumn('id_token', 'string', ['length' => 2000, 'notnull' => false]);

        $table->setPrimaryKey(['authorization_code']);
    }

    public function down(Schema $schema) : void
    {
        $schema->dropTable('authorization_codes');
    }
}
