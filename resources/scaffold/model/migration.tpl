<?php

use Phinx\Migration\AbstractMigration;

/**
 * Description of %$className%Migration
 *
 * @author Luís Pinto / luis.nestesitio@gmail.com
 * Created @%$dateCreated%
 */
class %$className%Migration extends AbstractMigration
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
        $table = $this->table('%$tableName%');
        $table{@while ($item in columns):}->addColumn('{$item.fieldName}', '{$item.fieldKind}')
        {@endwhile;}->create();
    }
    
    /**
     * Migrate Up.
     */
    public function up()
    {
        $table = $this->table('%$tableName%', ['id' => false, 'primary_key' => [%$primaryKeys%]]);
        $table{@while ($item in adds):}->addColumn('{$item.fieldName}', '{$item.fieldKind}', [{$item.fieldAttributes}])
        {@endwhile;}{@while ($item in removes):}->removeColumn('{$item.fieldName}')
        {@endwhile;}{@while ($item in indexes):}->addIndex(['{$item.fieldName}'])
        {@endwhile;}->save();
    }

    /**
     * Migrate Down.
     */
    public function down()
    {
        $table = $this->table('%$tableName%');
        $table{@while ($item in downs):}->removeColumn('{$item.fieldName}')
        {@endwhile;}{@while ($item in resumes):}->addColumn('{$item.fieldName}', 'fill type', ['fill attributes'])
        {@endwhile;}->save();
        
        $this->dropTable('%$tableName%');
    }
}
