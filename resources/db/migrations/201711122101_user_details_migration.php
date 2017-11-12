<?php

use Phinx\Migration\AbstractMigration;

/**
 * Description of UserDetailsMigration
 *
 * @author Luís Pinto / luis.nestesitio@gmail.com
 * Created @2017-11-12 21:13
 */
class UserDetailsMigration extends AbstractMigration
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
        $table = $this->table('user_details');
        $table->addColumn('user_id', 'integer')
        ->addColumn('address', 'varchar')
        ->addColumn('zip_code', 'varchar')
        ->addColumn('local', 'varchar')
        ->create();
    }
    
    /**
     * Migrate Up.
     */
    public function up()
    {
        $table = $this->table('user_details', ['id' => false, 'primary_key' => ['user_id']]);
        $table->addColumn('user_id', 'integer', ['limit' => 6])
        ->addColumn('address', 'varchar', ['limit' => 150])
        ->addColumn('zip_code', 'varchar', ['limit' => 30])
        ->addColumn('local', 'varchar', ['limit' => 100])
        ->save();
    }

    /**
     * Migrate Down.
     */
    public function down()
    {
        $table = $this->table('user_details');
        $table->removeColumn('user_id')
        ->removeColumn('address')
        ->removeColumn('zip_code')
        ->removeColumn('local')
        ->save();
        
        $this->dropTable('user_details');
    }
}
