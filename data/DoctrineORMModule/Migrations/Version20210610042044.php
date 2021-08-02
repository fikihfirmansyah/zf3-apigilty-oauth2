<?php declare(strict_types=1);

namespace DoctrineORMModule\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210610042044 extends AbstractMigration
{
    public function getDescription()
    {
        return 'Create oauth_clients table.';
    }

    public function up(Schema $schema) : void
    {
        $table = $schema->createTable('oauth_clients');

        $table->addColumn('client_id', 'string', ['length' => 80]);
        $table->addColumn('client_secret', 'string', ['length' => 80]);
        $table->addColumn('redirect_uri', 'string', ['length' => 2000]);
        $table->addColumn('grant_types', 'string', ['length' => 80, 'notnull' => false]);
        $table->addColumn('scopes', 'string', ['length' => 2000, 'notnull' => false]);
        $table->addColumn('user_id', 'string', ['length' => 255, 'notnull' => false]);

        $table->setPrimaryKey(['client_id']);
    }

    public function down(Schema $schema) : void
    {
        $schema->dropTable('oauth_clients');
    }
}
