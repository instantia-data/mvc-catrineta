<?php

use Phinx\Migration\AbstractMigration;

/**
 * Description of UserGroupMigration
 *
 * @author Luís Pinto / luis.nestesitio@gmail.com
 * Created @2017-11-12 21:13
 */
class UserGroupMigration extends AbstractMigration
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
        $table = $this->table('user_group');
        $table->addColumn('id', 'integer')
        ->addColumn('name', 'varchar')
        ->addColumn('description', 'varchar')
        ->create();
    }
    
    /**
     * Migrate Up.
     */
    public function up()
    {
        $table = $this->table('user_group', ['id' => false, 'primary_key' => ['id']]);
        $table->addColumn('id', 'integer', ['limit' => 6])
        ->addColumn('name', 'varchar', ['limit' => 50])
        ->addColumn('description', 'varchar', ['limit' => 100])
        ->save();
    }

    /**
     * Migrate Down.
     */
    public function down()
    {
        $table = $this->table('user_group');
        $table->removeColumn('id')
        ->removeColumn('name')
        ->removeColumn('description')
        ->save();
        
        $this->dropTable('user_group');
    }
}
