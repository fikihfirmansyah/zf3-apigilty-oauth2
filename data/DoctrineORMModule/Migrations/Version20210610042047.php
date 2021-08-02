<?php declare(strict_types=1);

namespace DoctrineORMModule\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210610042047 extends AbstractMigration
{
    public function getDescription()
    {
        return 'Create oauth_jwt table.';
    }

    public function up(Schema $schema) : void
    {
        $table = $schema->createTable('oauth_jwt');

        $table->addColumn('client_id', 'string', ['length' => 80]);
        $table->addColumn('subject', 'string', ['length' => 80, 'notnull' => false]);
        $table->addColumn('public_key', 'string', ['length' => 2000, 'notnull' => false]);

        $table->setPrimaryKey(['client_id']);
    }

    public function down(Schema $schema) : void
    {
        $schema->dropTable('oauth_jwt');
    }
}
