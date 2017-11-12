<?php

use Phinx\Migration\AbstractMigration;

/**
 * Description of UserHasGroupMigration
 *
 * @author Luís Pinto / luis.nestesitio@gmail.com
 * Created @2017-11-12 21:13
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
        $table->addColumn('user_id', 'integer')
        ->addColumn('user_group', 'integer')
        ->create();
    }
    
    /**
     * Migrate Up.
     */
    public function up()
    {
        $table = $this->table('user_has_group', ['id' => false, 'primary_key' => ['user_id', 'user_group']]);
        $table->addColumn('user_id', 'integer', ['limit' => 6])
        ->addColumn('user_group', 'integer', ['limit' => 6])
        ->addIndex(['user_group'])
        ->addIndex(['user_id'])
        ->save();
    }

    /**
     * Migrate Down.
     */
    public function down()
    {
        $table = $this->table('user_has_group');
        $table->removeColumn('user_id')
        ->removeColumn('user_group')
        ->save();
        
        $this->dropTable('user_has_group');
    }
}
