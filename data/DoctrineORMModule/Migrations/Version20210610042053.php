<?php declare(strict_types=1);

namespace DoctrineORMModule\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210610042053 extends AbstractMigration
{
    public function getDescription()
    {
        return 'Create oauth_users table.';
    }

    public function up(Schema $schema) : void
    {
        $table = $schema->createTable('oauth_users');

        $table->addColumn('username', 'string', ['length' => 255]);
        $table->addColumn('password', 'string', ['length' => 2000, 'notnull' => false]);
        $table->addColumn('first_name', 'string', ['length' =>  255, 'notnull' => false]);
        $table->addColumn('last_name', 'string', ['length' => 255, 'notnull' => false]);

        $table->setPrimaryKey(['username']);
    }

    public function down(Schema $schema) : void
    {
        $schema->dropTable('oauth_users');
    }
}
