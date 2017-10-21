<?php

use Phinx\Migration\AbstractMigration;

/**
 * Description of UserStatusMigration
 *
 * @author Luís Pinto / luis.nestesitio@gmail.com
 * Created @2017-10-21 19:12
 */
class UserStatusMigration extends AbstractMigration
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
        $table = $this->table('user_status');
        $table
        ->addColumn('id', '{$item.fieldType}')
        ->addColumn('name', '{$item.fieldType}')
        
        ->create();
    }
    
    /**
     * Migrate Up.
     */
    public function up()
    {
        $table = $this->table('user_status');
        $table
        ->addColumn('id', 'integer', ['limit' => 6])
        ->addColumn('name', 'varchar', ['limit' => 100])
        
        
        ->save();
    }

    /**
     * Migrate Down.
     */
    public function down()
    {
        $table = $this->table('user_status');
        $table
        ->removeColumn('id')
        ->removeColumn('name')
        
        
        ->save();
        
        $this->dropTable('user_status');
    }
}
