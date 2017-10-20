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
 * Description of UserGroup
 *
 * @author Luís Pinto / luis.nestesitio@gmail.com
 * Created @2017-10-13 12:27
 * Updated @2017-10-13 12:27 with columns id, name, description
 */
class UserGroup extends \Catrineta\orm\Model 
{

    const FIELD_USER_GROUP_ID = 'user_group.id';
    const FIELD_USER_GROUP_NAME = 'user_group.name';
    const FIELD_USER_GROUP_DESCRIPTION = 'user_group.description';
    
    const TABLE = 'user_group';
    
    //The column names
    protected $fields = ['id', 'name', 'description'];  
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
        $this->setColumnValue(self::FIELD_USER_GROUP_ID, $value);
    }

    public function getId() {
        return $this->getColumnValue(self::FIELD_USER_GROUP_ID);
    }
    
    
    
    public function setName($value) {
        $this->setColumnValue(self::FIELD_USER_GROUP_NAME, $value);
    }

    public function getName() {
        return $this->getColumnValue(self::FIELD_USER_GROUP_NAME);
    }
    
    
    
    public function setDescription($value) {
        $this->setColumnValue(self::FIELD_USER_GROUP_DESCRIPTION, $value);
    }

    public function getDescription() {
        return $this->getColumnValue(self::FIELD_USER_GROUP_DESCRIPTION);
    }
    
    
    
    
    
    
    /**
    * Return model object
    * 
    * @return new \Model\models\UserHasGroup;
    */
    public function getJoinUserHasGroup() {
        $obj = new \Model\models\UserHasGroup();
        $obj->merge($this);
        return $obj;
    }
    
    
    
    

}
