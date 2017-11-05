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
 * Description of UserGuard
 *
 * @author Luís Pinto / luis.nestesitio@gmail.com
 * Created @%$dateCreated%
 * %$dateUpdated%
 */
class UserGuard extends \Catrineta\orm\Model 
{

    const FIELD_USER_GUARD_USER_ID = 'user_guard.user_id';
    const FIELD_USER_GUARD_USERNAME = 'user_guard.username';
    const FIELD_USER_GUARD_SALT = 'user_guard.salt';
    const FIELD_USER_GUARD_USERKEY = 'user_guard.userkey';
    
    const TABLE = 'user_guard';
    
    //The column names
    protected $fields = ['user_id', 'username', 'salt', 'userkey'];  
    //The table name
    protected $tableName = self::TABLE;
    //Primary key
    protected $primaryKey = ['user_id'];
    //auto increment field
    protected $autoincrement = null;
    //Foreign keys
    protected $foreignKeys = ['user_id'];
    //Constrain by tables
    protected $foreignTables = ['user'];
    
    protected function setModel(){
        $this->columnNames[$this->tableName] = $this->fields;
    }
    
    public function __toString (){
        return $this->getUsername();
    }
    
    
    
    public function setUserId($value) {
        $this->setColumnValue(self::FIELD_USER_GUARD_USER_ID, $value);
    }

    public function getUserId() {
        return $this->getColumnValue(self::FIELD_USER_GUARD_USER_ID);
    }
    
    
    
    public function setUsername($value) {
        $this->setColumnValue(self::FIELD_USER_GUARD_USERNAME, $value);
    }

    public function getUsername() {
        return $this->getColumnValue(self::FIELD_USER_GUARD_USERNAME);
    }
    
    
    
    public function setSalt($value) {
        $this->setColumnValue(self::FIELD_USER_GUARD_SALT, $value);
    }

    public function getSalt() {
        return $this->getColumnValue(self::FIELD_USER_GUARD_SALT);
    }
    
    
    
    public function setUserkey($value) {
        $this->setColumnValue(self::FIELD_USER_GUARD_USERKEY, $value);
    }

    public function getUserkey() {
        return $this->getColumnValue(self::FIELD_USER_GUARD_USERKEY);
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
