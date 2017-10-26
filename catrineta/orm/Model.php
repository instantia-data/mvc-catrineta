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

namespace Catrineta\orm;

use \Catrineta\register\CatExceptions;
use \Catrineta\orm\query\QuerySelect;
use \Catrineta\register\Monitor;
use \Catrineta\orm\ModelTools;

/**
 * Description of Model
 *
 * @author Luís Pinto / luis.nestesitio@gmail.com
 * Created @Sep 8, 2017
 */
class Model
{
    
    use \Catrineta\orm\ModelQueryTools;
    
    //The column names
    protected $fields = [];  
    //The table name
    protected $tableName = null;
    //Primary key
    protected $primaryKey = [];
    //auto increment field
    protected $autoincrement = null;
    /**
     *
     * @var array The columns with some value
     */
    protected $columns = [];

    function __construct()
    {
        $this->setModel();
    }
    
    /**
     * 
     * @param string $column
     * @param mixed $value
     */
    function setColumnValue($column, $value)
    {
        $this->columns[$column] = $value;
    } 

    /**
     * 
     * @param string $column
     * @param string $value
     */
    public function setColumnDate($column, $value)
    {
        $this->columns[$column] = \Catrineta\tools\DateTools::convertToSqlDate($value);
    }
    
    /**
     * 
     * @param string $column
     * @return mixed
     */
    function getColumnValue($column)
    {
        if(isset($this->columns[$column])){
            return $this->columns[$column];
        }else{
            Monitor::add(Monitor::DATA, (empty($column))? 'Empty column' :'Invalid column ' . $column);
            return null;
        }
    }
    
    /**
     * Get the model with its values
     * @return array
     */
    public function get()
    {
        return $this->columns;
    }
    
    /**
     * @param Model $parent_model
     */
    public function merge(Model $parent_model)
    {
        $this->columns = $parent_model->getColumnValues();
    }
    
    /**
     * 
     * @return string
     */
    public function getTableName()
    {
        return $this->tableName;
    }
    
    /**
     * 
     * @return array
     */
    public function getFields()
    {
        return $this->fields;
    }
    
    public function getColumn($field)
    {
        return $this->tableName . '.' . $field;
    }
    
    /**
     * 
     * @return array
     */
    public function getPrimaryKeys()
    {
        return $this->primaryKey;
    }
    
    /**
     * 
     * @param string $column
     */
    public function addColumn($column)
    {
        $this->columns[$column] = 0;
    }
    
    /**
     * 
     * @return Model
     */
    public function insert()
    {
        if(!$this->checkConstrains()){
            return null;
        }
        $query = $this->setQuery($this->columns);
        try {
            $id = $query->insert($this->autoincrement);
            if($this->autoincrement != null){
                $column = ModelTools::completeColumnName($this->tableName, $this->autoincrement);
                $this->setColumnValue($column, $id);
            }
        } catch (CatExceptions $ex) {
            echo $ex->output();
        }
        Monitor::add(Monitor::MODEL, 'Model '. ModelTools::buildModelName($this->tableName).' inserted:' . print_r($this->get(), 1));
        return $this;
    }
    
    private function checkConstrains(){
        foreach($this->foreignKeys as $key){
            $column = ModelTools::completeColumnName($this->tableName, $key);            
            if($this->getColumnValue($column) == null){
                $value = $this->findConstraintValue($column);
                if($value != false){
                    $this->setColumnValue($column, $value);
                }else{
                    throw new CatExceptions('Integrity constraint violation, no value defined for ' . $column, CatExceptions::CODE_ORM);
                }
                
            }
        }
        return true;
    }
    
    private function findConstraintValue($column)
    {
        foreach($this->joins as $table=>$join){
            if($join['column'] == $column){
                $query = new QuerySelect(ModelTools::startModel($table));
                $query->setSelect($join['ref']);
                foreach ($join['wheres'] as $col=>$value){
                    $query->filterByColumn($col, $value);
                }
                $result = $query->findOne();
                return $result->getColumnValue($join['ref']);
            }
        }
        return false;
    }

    /**
     * 
     * @return Model
     */
    public function save()
    {
        //unmerge merged columns
        $this->unsetMerged($this->columns, $this->fields);
        
        if($this->hasId()){
            $query = $this->setQuery($this->columns);
            foreach ($this->primaryKey as $key){
                $column = $this->getColumn($key);
                $query->filterByColumn($column, $this->getColumnValue($column));
            }
            $this->update = $query->update();
            return $this;
        }else{
            return $this->insert();
        }
        
    }
    
    public $update = 0;


    /**
     * 
     * @return bool <b>TRUE</b> on success or <b>FALSE</b> on failure.
     * @throws CatExceptions
     */
    public function delete()
    {
        $query = $this->setQuery();
        foreach ($this->columns as $column=>$value){
            $query->filterByColumn($column, $value);
        }
        if($this->hasId()){
            throw new CatExceptions('Object is not unique for delete', CatExceptions::CODE_ORM);
        }else{
            return $query->delete();
        }
    }
    
    
    protected function hasId()
    {
        foreach ($this->primaryKey as $key){
            $column = ModelTools::completeColumnName($this->tableName, $key);
            if(!isset($this->columns[$column]) || empty($this->columns[$column])){
                return false;
            }
        }
        return true;
    }
    
    /**
     *
     * @var array 
     */
    protected $joins = [];


    /**
     * 
     * @param string $table
     * @param string $column
     * @param string $referenced_field
     */
    public function setJoin($table, $column, $referenced_field)
    {
        $field = ModelTools::getColumnName($column);
        if(in_array($field, $this->foreignKeys)){
            $this->joins[$table] = ['column'=>$column, 'ref'=>$referenced_field];
            $this->joins[$table]['wheres'] = [];
        }
    }
    
    public function joinCondition($table, $column, $value)
    {
        if(isset($this->joins[$table])){
            $this->joins[$table]['wheres'][$column] = $value;
        }
    }
    

}
