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
 * Description of UserHasGroup
 *
 * @author Luís Pinto / luis.nestesitio@gmail.com
 * Created @2017-11-12 21:13
 * Updated @2017-11-12 21:13 with columns user_id, user_group
 */
class UserHasGroup extends \Catrineta\orm\Model 
{

    const FIELD_USER_HAS_GROUP_USER_ID = 'user_has_group.user_id';
    const FIELD_USER_HAS_GROUP_USER_GROUP = 'user_has_group.user_group';
    
    const TABLE = 'user_has_group';
    
    //The column names
    protected $fields = ['user_id', 'user_group'];  
    //The table name
    protected $tableName = self::TABLE;
    //Primary key
    protected $primaryKey = ['user_id', 'user_group'];
    //auto increment field
    protected $autoincrement = null;
    //Foreign keys
    protected $foreignKeys = ['user_group', 'user_id'];
    //Constrain by tables
    protected $foreignTables = ['user_group', 'user'];
    
    protected function setModel(){
        $this->columnNames[$this->tableName] = $this->fields;
    }
    
    public function __toString (){
        return 1;
    }
    
    
    
    public function setUserId($value) {
        $this->setColumnValue(self::FIELD_USER_HAS_GROUP_USER_ID, $value);
    }

    public function getUserId() {
        return $this->getColumnValue(self::FIELD_USER_HAS_GROUP_USER_ID);
    }
    
    
    
    public function setUserGroup($value) {
        $this->setColumnValue(self::FIELD_USER_HAS_GROUP_USER_GROUP, $value);
    }

    public function getUserGroup() {
        return $this->getColumnValue(self::FIELD_USER_HAS_GROUP_USER_GROUP);
    }
    
    
    
    
    
    
    /**
    * Return model object
    * 
    * @return new \Model\models\UserGroup;
    */
    public function getJoinUserGroup() {
        $obj = new \Model\models\UserGroup();
        $obj->merge($this);
        return $obj;
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
