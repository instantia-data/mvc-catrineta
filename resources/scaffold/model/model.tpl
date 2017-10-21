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
 
namespace Model\models;


/**
 * Description of %$className%
 *
 * @author Luís Pinto / luis.nestesitio@gmail.com
 * Created @%$dateCreated%
 * %$dateUpdated%
 */
class %$className% extends \Catrineta\orm\Model 
{

    #%$fieldconstant%
    
    const TABLE = '%$tableName%';
    
    //The column names
    protected $fields = ['%$tableColumns%'];  
    //The table name
    protected $tableName = self::TABLE;
    //Primary key
    protected $primaryKey = ['%$primaryKeys%'];
    //auto increment field
    protected $autoincrement = %$incrementKey%;
    //Foreign keys
    protected $foreignKeys = [%$foreignKeys%];
    
    protected function setModel(){
        $this->columnNames[$this->tableName] = $this->fields;
    }
    
    public function __toString (){
        return $this->get%$toString%();
    }
    
    {@while ($item in columns):}
    
    public function set{$item.method}($value) {
        $this->setColumnValue({$item.tableColumn}, $value);
    }

    public function get{$item.method}() {
        return $this->getColumnValue({$item.tableColumn});
    }
    
    {@endwhile;}
    
    
    {@while ($item in joins):}
    
    /**
    * Return model object
    * 
    * @return new \Model\models\{$item.tableJoin};
    */
    public function getJoin{$item.tableJoin}() {
        $obj = new \Model\models\{$item.tableJoin}();
        $obj->merge($this);
        return $obj;
    }
    
    {@endwhile;}
    
    

}
