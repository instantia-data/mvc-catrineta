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
 
namespace Model\querys;

use \Model\models\UserDetails;
use \Catrineta\db\Sql;

/**
 * Description of UserDetails
 *
 * @author Luís Pinto / luis.nestesitio@gmail.com
 * Created @2017-11-12 21:13
 * Updated @Updated @2017-11-12 21:13 with columns user_id, address, zip_code, local *
 */
class UserDetailsQuery extends \Catrineta\orm\query\QuerySelect {
    
    /**
     * 
     * @param string $merge Possible values: ALL the columns | ONLY the id | false columns
     * @param string $alias Alias for the table
     * @return \Model\querys\UserDetailsQuery
     */
    public static function init($merge = ALL, $alias = null){
        $obj = new UserDetailsQuery(new UserDetails(), $alias);
        $obj->setAllSelects($merge);
        return $obj;
    }
    
    /**
     * Used to merge query classes on join tables
     * @param \Catrineta\orm\query\QuerySelect $merge The primary class
     * @return \Model\querys\UserDetailsQuery
     */
    public static function useModel(\Catrineta\orm\query\QuerySelect $merge){
        $obj = new UserDetailsQuery(new UserDetails());
        $obj->startJoin($merge);
        return $obj;
    }
    
    /**
     * Completes the join and return primary query,
     * because Netbeans we put child query on return, the program will get primary class function endUse()
     *
     * @return \Model\querys\UserDetailsQuery
     */
    public function endUse(){
        return parent::completeMerge();
    }
    
    
    /**
     * Completes query and return a collection of UserDetails objects
     *
     * @return \Model\models\UserDetails[]
     */
    public function find() {
        return parent::find();
    }
    
    /**
     * Completes query with limit 1.
     *
     * @return \Model\models\UserDetails
     */
    public function findOne(){
        return parent::findOne();
    }
    
    /**
     * Completes query. If result is 0 create object
     *
     * @return \Model\models\UserDetails
     */
    public function findOneOrCreate(){
        return parent::findOneOrCreate();
    }
    
    

    /**
     * 
     * @return \Model\querys\UserDetailsQuery
     */
    public function selectUserId($alias = null) {
        $this->setSelect(UserDetails::FIELD_USER_DETAILS_USER_ID, $alias);
        return $this;
    }
    
    /**
     * @param mixed $values 
     * @param string $operator SQL Operator
     * 
     * @return \Model\querys\UserDetailsQuery
     */
    public function filterByUserId($values, $operator = Sql::EQUAL) {
        $this->filterByColumn(UserDetails::FIELD_USER_DETAILS_USER_ID, $values, $operator);
        return $this;
    } 
    
    /**
     * 
     * @return \Model\querys\UserDetailsQuery
     */
    public function groupByUserId() {
        $this->groupBy(UserDetails::FIELD_USER_DETAILS_USER_ID);
        return $this;
    }
    
    /**
     * @param string $order (ASC | DESC)
     * 
     * @return \Model\querys\UserDetailsQuery
     */
    public function orderByUserId($order = Sql::ASC) {
        $this->orderBy(UserDetails::FIELD_USER_DETAILS_USER_ID, $order);
        return $this;
    }
    
    

    /**
     * 
     * @return \Model\querys\UserDetailsQuery
     */
    public function selectAddress($alias = null) {
        $this->setSelect(UserDetails::FIELD_USER_DETAILS_ADDRESS, $alias);
        return $this;
    }
    
    /**
     * @param mixed $values 
     * @param string $operator SQL Operator
     * 
     * @return \Model\querys\UserDetailsQuery
     */
    public function filterByAddress($values, $operator = Sql::EQUAL) {
        $this->filterByColumn(UserDetails::FIELD_USER_DETAILS_ADDRESS, $values, $operator);
        return $this;
    } 
    
    /**
     * 
     * @return \Model\querys\UserDetailsQuery
     */
    public function groupByAddress() {
        $this->groupBy(UserDetails::FIELD_USER_DETAILS_ADDRESS);
        return $this;
    }
    
    /**
     * @param string $order (ASC | DESC)
     * 
     * @return \Model\querys\UserDetailsQuery
     */
    public function orderByAddress($order = Sql::ASC) {
        $this->orderBy(UserDetails::FIELD_USER_DETAILS_ADDRESS, $order);
        return $this;
    }
    
    

    /**
     * 
     * @return \Model\querys\UserDetailsQuery
     */
    public function selectZipCode($alias = null) {
        $this->setSelect(UserDetails::FIELD_USER_DETAILS_ZIP_CODE, $alias);
        return $this;
    }
    
    /**
     * @param mixed $values 
     * @param string $operator SQL Operator
     * 
     * @return \Model\querys\UserDetailsQuery
     */
    public function filterByZipCode($values, $operator = Sql::EQUAL) {
        $this->filterByColumn(UserDetails::FIELD_USER_DETAILS_ZIP_CODE, $values, $operator);
        return $this;
    } 
    
    /**
     * 
     * @return \Model\querys\UserDetailsQuery
     */
    public function groupByZipCode() {
        $this->groupBy(UserDetails::FIELD_USER_DETAILS_ZIP_CODE);
        return $this;
    }
    
    /**
     * @param string $order (ASC | DESC)
     * 
     * @return \Model\querys\UserDetailsQuery
     */
    public function orderByZipCode($order = Sql::ASC) {
        $this->orderBy(UserDetails::FIELD_USER_DETAILS_ZIP_CODE, $order);
        return $this;
    }
    
    

    /**
     * 
     * @return \Model\querys\UserDetailsQuery
     */
    public function selectLocal($alias = null) {
        $this->setSelect(UserDetails::FIELD_USER_DETAILS_LOCAL, $alias);
        return $this;
    }
    
    /**
     * @param mixed $values 
     * @param string $operator SQL Operator
     * 
     * @return \Model\querys\UserDetailsQuery
     */
    public function filterByLocal($values, $operator = Sql::EQUAL) {
        $this->filterByColumn(UserDetails::FIELD_USER_DETAILS_LOCAL, $values, $operator);
        return $this;
    } 
    
    /**
     * 
     * @return \Model\querys\UserDetailsQuery
     */
    public function groupByLocal() {
        $this->groupBy(UserDetails::FIELD_USER_DETAILS_LOCAL);
        return $this;
    }
    
    /**
     * @param string $order (ASC | DESC)
     * 
     * @return \Model\querys\UserDetailsQuery
     */
    public function orderByLocal($order = Sql::ASC) {
        $this->orderBy(UserDetails::FIELD_USER_DETAILS_LOCAL, $order);
        return $this;
    }
    
    
    
    
    
    /**
     * Makes join
     * @param Mysql $join
     *
     * @return \Model\querys\UserQuery
     */
    function joinUser($join = Sql::INNER_JOIN, $alias = null) {
        $this->join(\Model\models\User::TABLE, $join, UserDetails::FIELD_USER_DETAILS_USER_ID, \Model\models\User::FIELD_USER_ID, $alias);
        return \Model\querys\UserQuery::useModel($this);
    }
    
    

}
