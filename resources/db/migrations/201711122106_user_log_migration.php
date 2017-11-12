<?php

use Phinx\Migration\AbstractMigration;

/**
 * Description of UserLogMigration
 *
 * @author Luís Pinto / luis.nestesitio@gmail.com
 * Created @2017-11-12 21:13
 */
class UserLogMigration extends AbstractMigration
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
        $table = $this->table('user_log');
        $table->addColumn('id', 'integer')
        ->addColumn('user_id', 'integer')
        ->addColumn('user_event', 'integer')
        ->addColumn('timestamp', 'datetime')
        ->create();
    }
    
    /**
     * Migrate Up.
     */
    public function up()
    {
        $table = $this->table('user_log', ['id' => false, 'primary_key' => ['id']]);
        $table->addColumn('id', 'integer', ['limit' => 6])
        ->addColumn('user_id', 'integer', ['limit' => 6])
        ->addColumn('user_event', 'integer', ['limit' => 6])
        ->addColumn('timestamp', 'datetime', ['default' => CURRENT_TIMESTAMP])
        ->addIndex(['user_id'])
        ->addIndex(['user_event'])
        ->save();
    }

    /**
     * Migrate Down.
     */
    public function down()
    {
        $table = $this->table('user_log');
        $table->removeColumn('id')
        ->removeColumn('user_id')
        ->removeColumn('user_event')
        ->removeColumn('timestamp')
        ->save();
        
        $this->dropTable('user_log');
    }
}
