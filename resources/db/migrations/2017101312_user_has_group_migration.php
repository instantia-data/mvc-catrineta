<?php

use Phinx\Migration\AbstractMigration;

/**
 * Description of UserHasGroupMigration
 *
 * @author Luís Pinto / luis.nestesitio@gmail.com
 * Created @2017-10-13 12:27
 */
class UserHasGroupMigration extends AbstractMigration
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
        $table = $this->table('user_has_group');
        $table
        ->addColumn('user_id', '{$item.fieldType}')
        ->addColumn('user_group', '{$item.fieldType}')
        
        ->create();
    }
    
    /**
     * Migrate Up.
     */
    public function up()
    {
        $table = $this->table('user_has_group');
        $table
        ->addColumn('user_id', 'integer', ['limit' => 6])
        ->addColumn('user_group', 'integer', ['limit' => 6])
        
        
        ->save();
    }

    /**
     * Migrate Down.
     */
    public function down()
    {
        $table = $this->table('user_has_group');
        $table
        ->removeColumn('user_id')
        ->removeColumn('user_group')
        
        
        ->save();
        
        $this->dropTable('user_has_group');
    }
}
