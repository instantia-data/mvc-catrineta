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
 * Description of UserLog
 *
 * @author Luís Pinto / luis.nestesitio@gmail.com
 * Created @2018-01-19 18:03
 * Updated @2018-01-19 18:03 with columns id, user_id, user_event, timestamp
 */
class UserLog extends \Catrineta\orm\Model 
{

    const FIELD_USER_LOG_ID = 'user_log.id';
    const FIELD_USER_LOG_USER_ID = 'user_log.user_id';
    const FIELD_USER_LOG_USER_EVENT = 'user_log.user_event';
    const FIELD_USER_LOG_TIMESTAMP = 'user_log.timestamp';
    
    const TABLE = 'user_log';
    
    //The column names
    protected $fields = ['id', 'user_id', 'user_event', 'timestamp'];  
    //The table name
    protected $tableName = self::TABLE;
    //Primary key
    protected $primaryKey = ['id'];
    //auto increment field
    protected $autoincrement = 'id';
    //Foreign keys
    protected $foreignKeys = ['user_event', 'user_id'];
    //Constraints
    protected $constraints = ['user_event' => ['table'=>'user_event', 'field'=>'id'], 'user_id' => ['table'=>'user', 'field'=>'id']];
    
    protected function setModel(){
        $this->columnNames[$this->tableName] = $this->fields;
    }
    
    public function __toString (){
        return 1;
    }
    
    
    
    public function setId($value) {
        $this->setColumnValue(self::FIELD_USER_LOG_ID, $value);
    }

    public function getId() {
        return $this->getColumnValue(self::FIELD_USER_LOG_ID);
    }
    
    
    
    public function setUserId($value) {
        $this->setColumnValue(self::FIELD_USER_LOG_USER_ID, $value);
    }

    public function getUserId() {
        return $this->getColumnValue(self::FIELD_USER_LOG_USER_ID);
    }
    
    
    
    public function setUserEvent($value) {
        $this->setColumnValue(self::FIELD_USER_LOG_USER_EVENT, $value);
    }

    public function getUserEvent() {
        return $this->getColumnValue(self::FIELD_USER_LOG_USER_EVENT);
    }
    
    
    
    public function setTimestamp($value) {
        $this->setColumnValue(self::FIELD_USER_LOG_TIMESTAMP, $value);
    }

    public function getTimestamp() {
        return $this->getColumnValue(self::FIELD_USER_LOG_TIMESTAMP);
    }
    
    
    
    
    
    
    /**
    * Return model object
    * 
    * @return new \Model\models\UserEvent;
    */
    public function getJoinUserEvent() {
        $obj = new \Model\models\UserEvent();
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
