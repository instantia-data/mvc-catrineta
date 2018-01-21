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
 * Description of UserDetails
 *
 * @author Luís Pinto / luis.nestesitio@gmail.com
 * Created @2018-01-19 18:03
 * Updated @2018-01-19 18:03 with columns user_id, address, zip_code, local
 */
class UserDetails extends \Catrineta\orm\Model 
{

    const FIELD_USER_DETAILS_USER_ID = 'user_details.user_id';
    const FIELD_USER_DETAILS_ADDRESS = 'user_details.address';
    const FIELD_USER_DETAILS_ZIP_CODE = 'user_details.zip_code';
    const FIELD_USER_DETAILS_LOCAL = 'user_details.local';
    
    const TABLE = 'user_details';
    
    //The column names
    protected $fields = ['user_id', 'address', 'zip_code', 'local'];  
    //The table name
    protected $tableName = self::TABLE;
    //Primary key
    protected $primaryKey = ['user_id'];
    //auto increment field
    protected $autoincrement = null;
    //Foreign keys
    protected $foreignKeys = ['user_id'];
    //Constraints
    protected $constraints = ['user_id' => ['table'=>'user', 'field'=>'id']];
    
    protected function setModel(){
        $this->columnNames[$this->tableName] = $this->fields;
    }
    
    public function __toString (){
        return $this->getAddress();
    }
    
    
    
    public function setUserId($value) {
        $this->setColumnValue(self::FIELD_USER_DETAILS_USER_ID, $value);
    }

    public function getUserId() {
        return $this->getColumnValue(self::FIELD_USER_DETAILS_USER_ID);
    }
    
    
    
    public function setAddress($value) {
        $this->setColumnValue(self::FIELD_USER_DETAILS_ADDRESS, $value);
    }

    public function getAddress() {
        return $this->getColumnValue(self::FIELD_USER_DETAILS_ADDRESS);
    }
    
    
    
    public function setZipCode($value) {
        $this->setColumnValue(self::FIELD_USER_DETAILS_ZIP_CODE, $value);
    }

    public function getZipCode() {
        return $this->getColumnValue(self::FIELD_USER_DETAILS_ZIP_CODE);
    }
    
    
    
    public function setLocal($value) {
        $this->setColumnValue(self::FIELD_USER_DETAILS_LOCAL, $value);
    }

    public function getLocal() {
        return $this->getColumnValue(self::FIELD_USER_DETAILS_LOCAL);
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
