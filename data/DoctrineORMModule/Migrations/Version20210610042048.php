<?php declare(strict_types=1);

namespace DoctrineORMModule\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210610042048 extends AbstractMigration
{
    public function getDescription()
    {
        return 'Create oauth_refresh_tokens table';
    }

    public function up(Schema $schema) : void
    {
        $table = $schema->createTable('oauth_refresh_tokens');

        $table->addColumn('refresh_token', 'string', ['length' => 40]);
        $table->addColumn('client_id', 'string', ['length' => 80]);
        $table->addColumn('user_id', 'string', ['length' => 255, 'notnull' => false]);
        $table->addColumn('expires', 'datetime', ['default' => 'CURRENT_TIMESTAMP']);
        $table->addColumn('scope', 'string', ['length' => 2000, 'notnull' => false]);

        $table->setPrimaryKey(['refresh_token']);
    }

    public function down(Schema $schema) : void
    {
        $schema->dropTable('oauth_refresh_tokens');
    }
}
