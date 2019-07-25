<?php


use Phinx\Db\Adapter\MysqlAdapter;
use Phinx\Migration\AbstractMigration;

class CreateUserTable extends AbstractMigration
{
    /**
     * Change Method.
     *
     * Write your reversible migrations using this method.
     *
     * More information on writing migrations is available here:
     * http://docs.phinx.org/en/latest/migrations.html#the-abstractmigration-class
     *
     * The following commands can be used in this method and Phinx will
     * automatically reverse them when rolling back:
     *
     *    createTable
     *    renameTable
     *    addColumn
     *    addCustomColumn
     *    renameColumn
     *    addIndex
     *    addForeignKey
     *
     * Any other destructive changes will result in an error when trying to
     * rollback the migration.
     *
     * Remember to call "create()" or "update()" and NOT "save()" when working
     * with the Table class.
     */
    public function change()
    {
        $table = $this->table('User', ['id' => false, 'primary_key' => 'idUser']);
        $table->addColumn('idUser', 'integer', ['signed' => false, 'identity' => true])
            ->addColumn('role', 'integer', ['signed' => false, 'limit' => MysqlAdapter::INT_TINY])
            ->addColumn('status', 'integer', ['signed' => false, 'limit' => MysqlAdapter::INT_TINY])
            ->addColumn('firstname', 'string', ['null' => true])
            ->addColumn('lastname', 'string', ['null' => true])
            ->addColumn('displayName', 'string', ['null' => true])
            ->addColumn('email', 'string')
            ->addColumn('password', 'char', ['limit' => 60])
            ->addColumn('creationDate', 'datetime')
            ->addColumn('lastUpdateDate', 'datetime', ['null' => true])
            ->addIndex('displayName', ['unique' => true, 'name' => 'idx_user_display_name'])
            ->addIndex('email', ['unique' => true, 'name' => 'idx_user_email'])
            ->create();
    }
}
