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
     * Migrate Up.
     * addForeignKey
     */
    public function up()
    {
        {@while ($item in adds):}
        $this->table('{$item.tableName}')->addForeignKey('{$item.fieldName}', '{$item.reference_table}', ['{$item.reference_field}'],
                            ['constraint'=>'{$item.foreign_key_name}'])->save();{@endwhile;}
    }

    /**
     * Migrate Down.
     */
    public function down()
    {
        {@while ($item in removes):}
        $this->table('{$item.tableName}')->dropForeignKey('{$item.fieldName}')->save();{@endwhile;}
        
    }
}

