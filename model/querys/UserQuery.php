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

use \Model\models\User;
use \Catrineta\db\Sql;

/**
 * Description of User
 *
 * @author Luís Pinto / luis.nestesitio@gmail.com
 * Created @2017-10-20 17:13
 * Updated @Updated @2017-10-20 17:13 with columns id, name, email, cellphone, user_status, created *
 */
class UserQuery extends \Catrineta\orm\query\QuerySelect {
    
    /**
     * 
     * @param string $merge Possible values: ALL the columns | ONLY the id | false columns
     * @param string $alias Alias for the table
     * @return \model\querys\UserQuery
     */
    public static function init($merge = ALL, $alias = null){
        $obj = new UserQuery(new User(), $alias);
        $obj->setAllSelects($merge);
        return $obj;
    }
    
    /**
     * Used to merge query classes on join tables
     * @param \Catrineta\orm\query\QuerySelect $merge The primary class
     * @return \model\querys\UserQuery
     */
    public static function useModel(\Catrineta\orm\query\QuerySelect $merge){
        $obj = new UserQuery(new User());
        $obj->startJoin($merge);
        return $obj;
    }
    
    /**
     * Completes the join and return primary query,
     * because Netbeans we put child query on return, the program will get primary class function endUse()
     *
     * @return \model\querys\UserQuery
     */
    public function endUse(){
        return parent::completeMerge();
    }
    
    
    /**
     * Completes query and return a collection of User objects
     *
     * @return \model\models\User[]
     */
    public function find() {
        return parent::find();
    }
    
    /**
     * Completes query with limit 1.
     *
     * @return \model\models\User
     */
    public function findOne(){
        return parent::findOne();
    }
    
    /**
     * Completes query. If result is 0 create object
     *
     * @return \model\models\User
     */
    public function findOneOrCreate(){
        return parent::findOneOrCreate();
    }
    
    

    /**
     * 
     * @return \model\querys\UserQuery
     */
    public function selectId($alias = null) {
        $this->setSelect(User::FIELD_USER_ID, $alias);
        return $this;
    }
    
    /**
     * @param mixed $values 
     * @param string $operator SQL Operator
     * 
     * @return \model\querys\UserQuery
     */
    public function filterById($values, $operator = Sql::EQUAL) {
        $this->filterByColumn(User::FIELD_USER_ID, $values, $operator);
        return $this;
    } 
    
    /**
     * 
     * @return \model\querys\UserQuery
     */
    public function groupById() {
        $this->groupBy(User::FIELD_USER_ID);
        return $this;
    }
    
    /**
     * @param string $order (ASC | DESC)
     * 
     * @return \model\querys\UserQuery
     */
    public function orderById($order = Sql::ASC) {
        $this->orderBy(User::FIELD_USER_ID, $order);
        return $this;
    }
    
    

    /**
     * 
     * @return \model\querys\UserQuery
     */
    public function selectName($alias = null) {
        $this->setSelect(User::FIELD_USER_NAME, $alias);
        return $this;
    }
    
    /**
     * @param mixed $values 
     * @param string $operator SQL Operator
     * 
     * @return \model\querys\UserQuery
     */
    public function filterByName($values, $operator = Sql::EQUAL) {
        $this->filterByColumn(User::FIELD_USER_NAME, $values, $operator);
        return $this;
    } 
    
    /**
     * 
     * @return \model\querys\UserQuery
     */
    public function groupByName() {
        $this->groupBy(User::FIELD_USER_NAME);
        return $this;
    }
    
    /**
     * @param string $order (ASC | DESC)
     * 
     * @return \model\querys\UserQuery
     */
    public function orderByName($order = Sql::ASC) {
        $this->orderBy(User::FIELD_USER_NAME, $order);
        return $this;
    }
    
    

    /**
     * 
     * @return \model\querys\UserQuery
     */
    public function selectEmail($alias = null) {
        $this->setSelect(User::FIELD_USER_EMAIL, $alias);
        return $this;
    }
    
    /**
     * @param mixed $values 
     * @param string $operator SQL Operator
     * 
     * @return \model\querys\UserQuery
     */
    public function filterByEmail($values, $operator = Sql::EQUAL) {
        $this->filterByColumn(User::FIELD_USER_EMAIL, $values, $operator);
        return $this;
    } 
    
    /**
     * 
     * @return \model\querys\UserQuery
     */
    public function groupByEmail() {
        $this->groupBy(User::FIELD_USER_EMAIL);
        return $this;
    }
    
    /**
     * @param string $order (ASC | DESC)
     * 
     * @return \model\querys\UserQuery
     */
    public function orderByEmail($order = Sql::ASC) {
        $this->orderBy(User::FIELD_USER_EMAIL, $order);
        return $this;
    }
    
    

    /**
     * 
     * @return \model\querys\UserQuery
     */
    public function selectCellphone($alias = null) {
        $this->setSelect(User::FIELD_USER_CELLPHONE, $alias);
        return $this;
    }
    
    /**
     * @param mixed $values 
     * @param string $operator SQL Operator
     * 
     * @return \model\querys\UserQuery
     */
    public function filterByCellphone($values, $operator = Sql::EQUAL) {
        $this->filterByColumn(User::FIELD_USER_CELLPHONE, $values, $operator);
        return $this;
    } 
    
    /**
     * 
     * @return \model\querys\UserQuery
     */
    public function groupByCellphone() {
        $this->groupBy(User::FIELD_USER_CELLPHONE);
        return $this;
    }
    
    /**
     * @param string $order (ASC | DESC)
     * 
     * @return \model\querys\UserQuery
     */
    public function orderByCellphone($order = Sql::ASC) {
        $this->orderBy(User::FIELD_USER_CELLPHONE, $order);
        return $this;
    }
    
    

    /**
     * 
     * @return \model\querys\UserQuery
     */
    public function selectUserStatus($alias = null) {
        $this->setSelect(User::FIELD_USER_USER_STATUS, $alias);
        return $this;
    }
    
    /**
     * @param mixed $values 
     * @param string $operator SQL Operator
     * 
     * @return \model\querys\UserQuery
     */
    public function filterByUserStatus($values, $operator = Sql::EQUAL) {
        $this->filterByColumn(User::FIELD_USER_USER_STATUS, $values, $operator);
        return $this;
    } 
    
    /**
     * 
     * @return \model\querys\UserQuery
     */
    public function groupByUserStatus() {
        $this->groupBy(User::FIELD_USER_USER_STATUS);
        return $this;
    }
    
    /**
     * @param string $order (ASC | DESC)
     * 
     * @return \model\querys\UserQuery
     */
    public function orderByUserStatus($order = Sql::ASC) {
        $this->orderBy(User::FIELD_USER_USER_STATUS, $order);
        return $this;
    }
    
    

    /**
     * 
     * @return \model\querys\UserQuery
     */
    public function selectCreated($alias = null) {
        $this->setSelect(User::FIELD_USER_CREATED, $alias);
        return $this;
    }
    
    /**
     * @param mixed $values 
     * @param string $operator SQL Operator
     * 
     * @return \model\querys\UserQuery
     */
    public function filterByCreated($values, $operator = Sql::EQUAL) {
        $this->filterByDateColumn(User::FIELD_USER_CREATED, $values, $operator);
        return $this;
    } 
    
    /**
     * 
     * @return \model\querys\UserQuery
     */
    public function groupByCreated() {
        $this->groupBy(User::FIELD_USER_CREATED);
        return $this;
    }
    
    /**
     * @param string $order (ASC | DESC)
     * 
     * @return \model\querys\UserQuery
     */
    public function orderByCreated($order = Sql::ASC) {
        $this->orderBy(User::FIELD_USER_CREATED, $order);
        return $this;
    }
    
    
    
    
    
    /**
     * Makes join
     * @param Mysql $join
     *
     * @return \Model\querys\UserLogQuery
     */
    function joinUserLog($join = Sql::INNER_JOIN, $alias = null) {
        $this->join(\Model\models\UserLog::TABLE, $join, User::FIELD_USER_ID, \Model\models\UserLog::FIELD_USER_LOG_USER_ID, $alias);
        return \Model\querys\UserLogQuery::useModel($this);
    }
    
    
    
    /**
     * Makes join
     * @param Mysql $join
     *
     * @return \Model\querys\UserStatusQuery
     */
    function joinUserStatus($join = Sql::INNER_JOIN, $alias = null) {
        $this->join(\Model\models\UserStatus::TABLE, $join, User::FIELD_USER_USER_STATUS, \Model\models\UserStatus::FIELD_USER_STATUS_ID, $alias);
        return \Model\querys\UserStatusQuery::useModel($this);
    }
    
    

}
