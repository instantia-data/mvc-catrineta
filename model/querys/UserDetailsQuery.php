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
 
namespace model\querys;

use \Model\models\UserDetails;
use \Catrineta\orm\mysql\Mysql;

/**
 * Description of UserDetails
 *
 * @author Luís Pinto / luis.nestesitio@gmail.com
 * Created @2017-09-22 17:25
 * Updated @Updated @2017-09-22 17:25 with columns user_id, address, zip_code, local *
 */
class UserDetailsQuery extends \Catrineta\orm\query\QuerySelect {
    
    public static function start($merge = ALL){
        $obj = new UserDetailsQuery(new UserDetails(), $merge);
        $obj->startPrimary($merge);
        return $obj;
    }
    
    public static function useModel($merge){
        $obj = new UserDetailsQuery(new UserDetails());
        $obj->startJoin($merge);
        return $obj;
    }
    
    /**
     * Completes the join and return primary query,
     * because Netbeans we put child query on return, the program will get primary class function endUse()
     *
     * @return \model\querys\UserDetailsQuery
     */
    public function endUse(){
        return parent::completeMerge();
    }
    
    
    /**
     * Completes query and return a collection of UserDetails objects
     *
     * @return \model\models\UserDetails[]
     */
    public function find() {
        return parent::find();
    }
    
    /**
     * Completes query with limit 1.
     *
     * @return \model\models\UserDetails
     */
    public function findOne(){
        return parent::findOne();
    }
    
    /**
     * Completes query. If result is 0 create object
     *
     * @return \model\models\UserDetails
     */
    public function findOneOrCreate(){
        return parent::findOneOrCreate();
    }
    
    

    /**
     * 
     * @return \model\querys\UserDetailsQuery
     */
    public function selectUserId() {
        $this->setSelect(UserDetails::FIELD_USER_DETAILS_USER_ID);
        return $this;
    }
    
    /**
     * @param mixed $values 
     * @param string $operator SQL Operator
     * 
     * @return \model\querys\UserDetailsQuery
     */
    public function filterByUserId($values, $operator = Mysql::EQUAL) {
        $this->filterByColumn(UserDetails::FIELD_USER_DETAILS_USER_ID, $values, $operator);
        return $this;
    } 
    
    /**
     * @param string $order 
     * 
     * @return \model\querys\UserDetailsQuery
     */
    public function orderByUserId($order = Mysql::ASC) {
        $this->orderBy(UserDetails::FIELD_USER_DETAILS_USER_ID, $order);
        return $this;
    }
    
    /**
     * 
     * @return \model\querys\UserDetailsQuery
     */
    public function groupByUserId() {
        $this->groupBy(UserDetails::FIELD_USER_DETAILS_USER_ID);
        return $this;
    }
    
    

    /**
     * 
     * @return \model\querys\UserDetailsQuery
     */
    public function selectAddress() {
        $this->setSelect(UserDetails::FIELD_USER_DETAILS_ADDRESS);
        return $this;
    }
    
    /**
     * @param mixed $values 
     * @param string $operator SQL Operator
     * 
     * @return \model\querys\UserDetailsQuery
     */
    public function filterByAddress($values, $operator = Mysql::EQUAL) {
        $this->filterByColumn(UserDetails::FIELD_USER_DETAILS_ADDRESS, $values, $operator);
        return $this;
    } 
    
    /**
     * @param string $order 
     * 
     * @return \model\querys\UserDetailsQuery
     */
    public function orderByAddress($order = Mysql::ASC) {
        $this->orderBy(UserDetails::FIELD_USER_DETAILS_ADDRESS, $order);
        return $this;
    }
    
    /**
     * 
     * @return \model\querys\UserDetailsQuery
     */
    public function groupByAddress() {
        $this->groupBy(UserDetails::FIELD_USER_DETAILS_ADDRESS);
        return $this;
    }
    
    

    /**
     * 
     * @return \model\querys\UserDetailsQuery
     */
    public function selectZipCode() {
        $this->setSelect(UserDetails::FIELD_USER_DETAILS_ZIP_CODE);
        return $this;
    }
    
    /**
     * @param mixed $values 
     * @param string $operator SQL Operator
     * 
     * @return \model\querys\UserDetailsQuery
     */
    public function filterByZipCode($values, $operator = Mysql::EQUAL) {
        $this->filterByColumn(UserDetails::FIELD_USER_DETAILS_ZIP_CODE, $values, $operator);
        return $this;
    } 
    
    /**
     * @param string $order 
     * 
     * @return \model\querys\UserDetailsQuery
     */
    public function orderByZipCode($order = Mysql::ASC) {
        $this->orderBy(UserDetails::FIELD_USER_DETAILS_ZIP_CODE, $order);
        return $this;
    }
    
    /**
     * 
     * @return \model\querys\UserDetailsQuery
     */
    public function groupByZipCode() {
        $this->groupBy(UserDetails::FIELD_USER_DETAILS_ZIP_CODE);
        return $this;
    }
    
    

    /**
     * 
     * @return \model\querys\UserDetailsQuery
     */
    public function selectLocal() {
        $this->setSelect(UserDetails::FIELD_USER_DETAILS_LOCAL);
        return $this;
    }
    
    /**
     * @param mixed $values 
     * @param string $operator SQL Operator
     * 
     * @return \model\querys\UserDetailsQuery
     */
    public function filterByLocal($values, $operator = Mysql::EQUAL) {
        $this->filterByColumn(UserDetails::FIELD_USER_DETAILS_LOCAL, $values, $operator);
        return $this;
    } 
    
    /**
     * @param string $order 
     * 
     * @return \model\querys\UserDetailsQuery
     */
    public function orderByLocal($order = Mysql::ASC) {
        $this->orderBy(UserDetails::FIELD_USER_DETAILS_LOCAL, $order);
        return $this;
    }
    
    /**
     * 
     * @return \model\querys\UserDetailsQuery
     */
    public function groupByLocal() {
        $this->groupBy(UserDetails::FIELD_USER_DETAILS_LOCAL);
        return $this;
    }
    
    
    
    
    
    /**
     * Makes join
     * @param Mysql $join
     *
     * @return \Model\querys\UserQuery
     */
    function joinUser($join = Mysql::INNER_JOIN) {
        $this->join(\Model\models\User::TABLE, $join, [UserDetails::FIELD_USER_DETAILS_USER_ID, \Model\models\User::FIELD_USER_ID]);
        return \Model\querys\UserQuery::useModel($this);
    }
    
    

}
