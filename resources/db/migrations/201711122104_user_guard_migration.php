<?php

use Phinx\Migration\AbstractMigration;

/**
 * Description of UserGuardMigration
 *
 * @author Luís Pinto / luis.nestesitio@gmail.com
 * Created @2017-11-12 21:13
 */
class UserGuardMigration extends AbstractMigration
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
        $table = $this->table('user_guard');
        $table->addColumn('user_id', 'integer')
        ->addColumn('username', 'varchar')
        ->addColumn('salt', 'varchar')
        ->addColumn('userkey', 'varchar')
        ->create();
    }
    
    /**
     * Migrate Up.
     */
    public function up()
    {
        $table = $this->table('user_guard', ['id' => false, 'primary_key' => ['user_id']]);
        $table->addColumn('user_id', 'integer', ['limit' => 6])
        ->addColumn('username', 'varchar', ['limit' => 100])
        ->addColumn('salt', 'varchar', ['limit' => 128])
        ->addColumn('userkey', 'varchar', ['limit' => 128])
        ->save();
    }

    /**
     * Migrate Down.
     */
    public function down()
    {
        $table = $this->table('user_guard');
        $table->removeColumn('user_id')
        ->removeColumn('username')
        ->removeColumn('salt')
        ->removeColumn('userkey')
        ->save();
        
        $this->dropTable('user_guard');
    }
}
