<?php declare(strict_types=1);

namespace DoctrineORMModule\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210610045001 extends AbstractMigration
{
    public function getDescription()
    {
        return 'Create user_reset_passwords table.';
    }

    public function up(Schema $schema) : void
    {
        $table = $schema->createTable('user_reset_passwords');

        $table->addColumn('uuid', 'string', ['length' => 36]);
        $table->addColumn('email', 'string', ['length' => 255, 'notnull', false]);
        $table->addColumn('expiration', 'datetime', []);
        $table->addColumn('reseted', 'datetime', ['notnull' => false]);
        $table->addColumn('password', 'string', ['length' => 255, 'notnull' => false]);
        $table->addColumn('create_at', 'datetime', ['default' => 'CURRENT_TIMESTAMP']);
        $table->addColumn('updated_at', 'datetime', ['default' => 'CURRENT_TIMESTAMP']);
        $table->addColumn('deleted_at', 'datetime', ['notnull' => false]);

        $table->setPrimaryKey(['uuid']);

        $table->addIndex(['email'], 'user_email_idx');

        $table->addForeignKeyConstraint(
            'oauth_users',
            ['email'],
            ['username'],
            ['onUpdate' => 'CASCADE', 'onDelete' => 'CASCADE'],
            'user_reset_oauth_users_fk'
        );
    }

    public function down(Schema $schema) : void
    {
        $schema->dropTable('user_reset_passwords');
    }
}
