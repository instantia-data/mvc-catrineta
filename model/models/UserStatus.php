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
 * Description of UserStatus
 *
 * @author Luís Pinto / luis.nestesitio@gmail.com
 * Created @2017-09-22 17:25
 * Updated @2017-09-22 17:25 with columns id, name
 */
class UserStatus extends \Catrineta\orm\Model 
{

    const FIELD_USER_STATUS_ID = 'user_status.id';
    const FIELD_USER_STATUS_NAME = 'user_status.name';
    
    const TABLE = 'user_status';
    
    //The column names
    protected $fields = ['id', 'name'];  
    //The table name
    protected $tableName = self::TABLE;
    //Primary key
    protected $primaryKey = ['id'];
    //auto increment field
    protected $autoincrement = 'id';
    
    protected function setModel(){
        $this->columnNames[$this->tableName] = $this->fields;
    }
    
    public function __toString (){
        return $this->getName();
    }
    
    
    
    public function setId($value) {
        $this->setColumnValue(self::FIELD_USER_STATUS_ID, $value);
    }

    public function getId() {
        return $this->getColumnValue(self::FIELD_USER_STATUS_ID);
    }
    
    
    
    public function setName($value) {
        $this->setColumnValue(self::FIELD_USER_STATUS_NAME, $value);
    }

    public function getName() {
        return $this->getColumnValue(self::FIELD_USER_STATUS_NAME);
    }
    
    
    
    
    
    
    /**
    * Return model object
    * 
    * @return new \Model\models\User;
    */
    public function getJoinUser() {
        $obj = new \Model\models\User();
        $obj->merge($this);
        return $obj;
    }
    
    
    
    

}
