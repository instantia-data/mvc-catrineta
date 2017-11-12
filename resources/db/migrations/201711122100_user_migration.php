<?php

use Phinx\Migration\AbstractMigration;

/**
 * Description of UserMigration
 *
 * @author Luís Pinto / luis.nestesitio@gmail.com
 * Created @2017-11-12 21:13
 */
class UserMigration extends AbstractMigration
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
     *    renameColumn
     *    addIndex
     *    addForeignKey
     *
     * Remember to call "create()" or "update()" and NOT "save()" when working
     * with the Table class.
     */
    public function change()
    {
        // create the table
        $table = $this->table('user');
        $table->addColumn('id', 'integer')
        ->addColumn('name', 'varchar')
        ->addColumn('email', 'varchar')
        ->addColumn('cellphone', 'varchar')
        ->addColumn('user_status', 'integer')
        ->addColumn('created', 'datetime')
        ->create();
    }
    
    /**
     * Migrate Up.
     */
    public function up()
    {
        $table = $this->table('user', ['id' => false, 'primary_key' => ['id']]);
        $table->addColumn('id', 'integer', ['limit' => 6])
        ->addColumn('name', 'varchar', ['limit' => 100])
        ->addColumn('email', 'varchar', ['limit' => 150])
        ->addColumn('cellphone', 'varchar', ['limit' => 20])
        ->addColumn('user_status', 'integer', ['limit' => 6])
        ->addColumn('created', 'datetime', ['default' => CURRENT_TIMESTAMP])
        ->addIndex(['user_status'])
        ->save();
    }

    /**
     * Migrate Down.
     */
    public function down()
    {
        $table = $this->table('user');
        $table->removeColumn('id')
        ->removeColumn('name')
        ->removeColumn('email')
        ->removeColumn('cellphone')
        ->removeColumn('user_status')
        ->removeColumn('created')
        ->save();
        
        $this->dropTable('user');
    }
}
