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

namespace Tasks\catrineta\lib;

use \Catrineta\console\crud\CrudTools;
use \Catrineta\console\crud\ParseLoop;

/**
 * Description of CrudMigrate
 *
 * @author Luís Pinto / luis.nestesitio@gmail.com
 * Created @Sep 15, 2017
 */
class CrudMigrate extends \Catrineta\console\crud\ModelCrud
{

    
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
    public function migrateFile()
    {
        $filename = date('YmdH') . '_' . $this->table . '_migration.php';
        $this->template = RESOURCES_DIR . 'scaffold' . DS . 'model' . DS . 'migration.tpl';
        $this->file = RESOURCES_DIR . 'db' . DS. 'migrations' . DS . $filename;
        
        $writearr = ['class'=>$this->classname, 'created'=>date('Y-m-d H:i'), 
            'updated'=>'Updated @' . date('Y-m-d H:i')];
        
        if(is_file($this->file)){

            unlink($this->file);
            
        }
        $this->string = CrudTools::copyFile($this->template, $this->file, $writearr);
        
        //set table name
        $this->string = str_replace('%$tableName%', $this->table, $this->string);
        file_put_contents($this->file, $this->string);
        
        return $filename;

    }
    
    public function parseLoops()
    {
        $parse = new ParseLoop($this->string);
        $this->loopNew($parse);
        $this->loopUpdate($parse);
        
        file_put_contents($this->file, $parse->parseWhile());
    }
    
    public function loopNew(ParseLoop $parse)
    {
        if (isset($this->migration['new'])) {
            foreach ($this->migration['new'] as $field) {
                $parse->setData('columns', $this->getFieldAttrs($field));
                $parse->setData('adds', $this->getFieldAttrs($field));  
                $parse->setData('downs', $this->getFieldAttrs($field));
            }
        }
    }
    
    public function loopUpdate(ParseLoop $parse)
    {
        if (isset($this->migration['added'])) {
            foreach ($this->migration['added'] as $field) {
                $parse->setData('columns', $this->getFieldAttrs($field));
                $parse->setData('adds', $this->getFieldAttrs($field));
                $parse->setData('downs', $this->getFieldAttrs($field));
            }
        }
        if (isset($this->migration['removes'])) {
            //here we only have the table name
            foreach ($this->migration['removes'] as $field) {
                $parse->setData('removes', ['fieldName'=>$field]);
                $parse->setData('resumes', ['fieldName'=>$field]);
            }
        }
    }
    
    /**
     * 
     * @param array $field
     * @return array
     */
    private function getFieldAttrs($field)
    {
        $attrs = '';
        if($field['Size'] != 0){
            $attrs .= "'limit' => " . $field['Size'];
        }
        if($field['Default'] != null){
            $attrs .= "'default' => " . $field['Default'];
        }
        
        return [
            'fieldName' => $field['Field'], 
            'fieldKind' => str_replace(['int'], ['integer'], $field['Kind']),
            'fieldAttributes'=>$attrs
        ];
    }

}
