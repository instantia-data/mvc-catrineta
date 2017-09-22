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
 * Description of User
 *
 * @author Luís Pinto / luis.nestesitio@gmail.com
 * Created @2017-09-22 17:25
 * Updated @2017-09-22 17:25 with columns id, name, email, cellphone, user_status, created
 */
class User extends \Catrineta\orm\Model 
{

    const FIELD_USER_ID = 'user.id';
    const FIELD_USER_NAME = 'user.name';
    const FIELD_USER_EMAIL = 'user.email';
    const FIELD_USER_CELLPHONE = 'user.cellphone';
    const FIELD_USER_USER_STATUS = 'user.user_status';
    const FIELD_USER_CREATED = 'user.created';
    
    const TABLE = 'user';
    
    //The column names
    protected $fields = ['id', 'name', 'email', 'cellphone', 'user_status', 'created'];  
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
        $this->setColumnValue(self::FIELD_USER_ID, $value);
    }

    public function getId() {
        return $this->getColumnValue(self::FIELD_USER_ID);
    }
    
    
    
    public function setName($value) {
        $this->setColumnValue(self::FIELD_USER_NAME, $value);
    }

    public function getName() {
        return $this->getColumnValue(self::FIELD_USER_NAME);
    }
    
    
    
    public function setEmail($value) {
        $this->setColumnValue(self::FIELD_USER_EMAIL, $value);
    }

    public function getEmail() {
        return $this->getColumnValue(self::FIELD_USER_EMAIL);
    }
    
    
    
    public function setCellphone($value) {
        $this->setColumnValue(self::FIELD_USER_CELLPHONE, $value);
    }

    public function getCellphone() {
        return $this->getColumnValue(self::FIELD_USER_CELLPHONE);
    }
    
    
    
    public function setUserStatus($value) {
        $this->setColumnValue(self::FIELD_USER_USER_STATUS, $value);
    }

    public function getUserStatus() {
        return $this->getColumnValue(self::FIELD_USER_USER_STATUS);
    }
    
    
    
    public function setCreated($value) {
        $this->setColumnValue(self::FIELD_USER_CREATED, $value);
    }

    public function getCreated() {
        return $this->getColumnValue(self::FIELD_USER_CREATED);
    }
    
    
    
    
    
    
    /**
    * Return model object
    * 
    * @return new \Model\models\UserLog;
    */
    public function getJoinUserLog() {
        $obj = new \Model\models\UserLog();
        $obj->merge($this);
        return $obj;
    }
    
    
    
    /**
    * Return model object
    * 
    * @return new \Model\models\UserStatus;
    */
    public function getJoinUserStatus() {
        $obj = new \Model\models\UserStatus();
        $obj->merge($this);
        return $obj;
    }
    
    
    
    

}
