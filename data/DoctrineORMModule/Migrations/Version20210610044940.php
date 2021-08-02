<?php declare(strict_types=1);

namespace DoctrineORMModule\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210610044940 extends AbstractMigration
{
    public function getDescription()
    {
        return 'Create user_accounts table.';
    }

    public function up(Schema $schema) : void
    {
        $table = $schema->createTable('user_accounts');

        $table->addColumn('uuid', 'string', ['length' => 36]);
        $table->addColumn('username', 'string', ['length' => 255]);
        $table->addColumn('email', 'string', ['length' => 64, 'notnull' => false]);
        $table->addColumn('phone', 'string', ['length' => 128, 'notnull' => false]);
        $table->addColumn('name', 'string', ['length' => 128]);
        $table->addColumn('created_at', 'datetime', ['default' => 'CURRENT_TIMESTAMP']);
        $table->addColumn('updated_at', 'datetime', ['default' => 'CURRENT_TIMESTAMP']);
        $table->addColumn('deleted_at', 'datetime', ['notnull' => false]);

        $table->setPrimaryKey(['uuid']);

        $table->addIndex(['username'], 'user_username_idx');
        $table->addIndex(['email'], 'user_email_idx');
        $table->addIndex(['phone'], 'user_phone_idx');
        $table->addIndex(['name'], 'user_name_idx');

        $table->addForeignKeyConstraint(
            'oauth_users',
            ['username'],
            ['username'],
            ['onUpdate' => 'CASCADE'],
            'user_oauth_users_fk'
        );
    }

    public function down(Schema $schema) : void
    {
        $schema->dropTable('user_accounts');
    }
}
