<?php

/*
 * Copyright (C) 2017 Luis Pinto <luis.nestesitio@gmail.com>
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 */

namespace Catrineta\console\lib;

use \Catrineta\console\crud\CrudTools;
use \Catrineta\console\crud\ParseLoop;
use \Catrineta\orm\ModelTools;

/**
 * Description of CrudFkMigration
 *
 * @author Luís Pinto / luis.nestesitio@gmail.com
 * Created @Nov 10, 2017
 */
class CrudFkMigration
{

    protected $file;
    
    protected $template;
    

    function __construct($classname)
    {
        $this->classname = $classname;
        
    }
    
    private $migration = [];
    
    /**
     * Set content to generate
     * ['new'=> $columns];
     * or
     * ['removes'=>$removes, 'added'=>$new_columns, 'resume'=>$str];
     * @param array $migrate
     */
    public function setMigrates($migrate)
    {
        $this->migration = $migrate;
        
        if(count($this->migration) > 0){
            return true;
        }else{
            return false;
        }
    }
    
    /**
     * Create model file
     * @param string $class The namespace class
     */
    /**
     * 
     * @param type $counter
     * @return string
     */
    public function migrateFile($counter)
    {
        $filename = date('YmdH') . str_pad($counter, 2, '0', STR_PAD_LEFT) . '_' . $this->classname . '_constraints_migration.php';
        $this->template = RESOURCES_DIR . 'scaffold' . DS . 'model' . DS . 'fk_migration.tpl';
        $this->file = RESOURCES_DIR . 'db' . DS. 'migrations' . DS . $filename;
        
        $writearr = ['className'=> ModelTools::buildModelName($this->classname), 
            'dateCreated'=>date('Y-m-d H:i'), 
            'updated'=>'Updated @' . date('Y-m-d H:i')];
        
        if(is_file($this->file)){
            unlink($this->file); 
        }
        $this->string = CrudTools::copyFile($this->template, $this->file, $writearr);
        
        return $filename;

    }
    
    public function parseLoops()
    {
        $parse = new ParseLoop($this->string);
        foreach($this->migration as $migration){
            foreach(['new', 'added', 'removes'] as $index){
                if(isset($migration[$index])){
                    $this->loop($parse, $migration[$index], $index);
                }
            }
        }
        $this->string = $parse->parseWhile();
        $this->changeName();
        file_put_contents($this->file, $this->string);
    }
    
    public function loop(ParseLoop $parse, $migration, $index)
    {
        foreach($migration as $constraint){
            $this->name = $this->makeName($constraint['CONSTRAINED']);
            if($index == 'new' || $index == 'added'){
                $parse->setData('adds', $this->getConstraintAttributes($constraint));
                $parse->setData('removes', $this->getConstraintAttributes($constraint));
            }
            
        }
    }
    
    private $name = '';
    
    private function changeName()
    {
        echo ModelTools::buildModelName($this->classname) . " --\n";
        echo ModelTools::buildModelName($this->name) . " --\n";
        $this->string = str_replace(
                ModelTools::buildModelName($this->classname), 
                ModelTools::buildModelName($this->name), 
                $this->string
                );
        
        $newfile = str_replace($this->classname, $this->name, $this->file);
        rename($this->file, $newfile);
        $this->file = $newfile;
    }
    
    /**
     *     [TABLE_NAME] => user_details
    [CONSTRAINED] => user_details
    [CONSTRAINT_TYPE] => FOREIGN KEY
    [REFERENCED_TABLE_NAME] => user
    [REFERENCED_COLUMN_NAME] => id
    [COLUMN_NAME] => user_id
    [CONSTRAINT_NAME] => fk_user_details_user1
     * $this->table('{$item.tableName}')->addForeignKey('{$item.fieldName}', '{$item.reference_table}', ['{$item.reference_field}'],
                            ['constraint'=>'{$item.foreign_key_name}'->save();
     * $this->table('{$item.tableName}')->dropForeignKey('{$item.fieldName}')->save();
     * @param type $constraint
     */
    private function getConstraintAttributes($constraint)
    {
        return [
            'tableName'=>$constraint['CONSTRAINED'],
            'fieldName' => $constraint['COLUMN_NAME'],
            'reference_table' => $constraint['REFERENCED_TABLE_NAME'],
            'reference_field'=> $constraint['REFERENCED_COLUMN_NAME'],
            'foreign_key_name'=> $constraint['CONSTRAINT_NAME'],
        ];
    }
    
    private $arr_name = [];

    private function makeName($name)
    {
        $arr = str_split($name);
        foreach($arr as $i=>$letter){
            if(!isset($this->arr_name[$i][$letter])){
                $this->arr_name[$i][$letter] = 1;
            }else{
                $this->arr_name[$i][$letter]++;
            }
        }
        $str = '';
        foreach($this->arr_name as $index){
            arsort($index);
            $str .= current(array_keys($index));
        }
        
        return $str;
    }

}
