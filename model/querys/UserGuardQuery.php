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

use \Model\models\UserGuard;
use \Catrineta\orm\mysql\Mysql;

/**
 * Description of UserGuard
 *
 * @author Luís Pinto / luis.nestesitio@gmail.com
 * Created @2017-09-22 17:25
 * Updated @Updated @2017-09-22 17:25 with columns user_id, username, salt, userkey *
 */
class UserGuardQuery extends \Catrineta\orm\query\QuerySelect {
    
    public static function start($merge = ALL){
        $obj = new UserGuardQuery(new UserGuard(), $merge);
        $obj->startPrimary($merge);
        return $obj;
    }
    
    public static function useModel($merge){
        $obj = new UserGuardQuery(new UserGuard());
        $obj->startJoin($merge);
        return $obj;
    }
    
    /**
     * Completes the join and return primary query,
     * because Netbeans we put child query on return, the program will get primary class function endUse()
     *
     * @return \model\querys\UserGuardQuery
     */
    public function endUse(){
        return parent::completeMerge();
    }
    
    
    /**
     * Completes query and return a collection of UserGuard objects
     *
     * @return \model\models\UserGuard[]
     */
    public function find() {
        return parent::find();
    }
    
    /**
     * Completes query with limit 1.
     *
     * @return \model\models\UserGuard
     */
    public function findOne(){
        return parent::findOne();
    }
    
    /**
     * Completes query. If result is 0 create object
     *
     * @return \model\models\UserGuard
     */
    public function findOneOrCreate(){
        return parent::findOneOrCreate();
    }
    
    

    /**
     * 
     * @return \model\querys\UserGuardQuery
     */
    public function selectUserId() {
        $this->setSelect(UserGuard::FIELD_USER_GUARD_USER_ID);
        return $this;
    }
    
    /**
     * @param mixed $values 
     * @param string $operator SQL Operator
     * 
     * @return \model\querys\UserGuardQuery
     */
    public function filterByUserId($values, $operator = Mysql::EQUAL) {
        $this->filterByColumn(UserGuard::FIELD_USER_GUARD_USER_ID, $values, $operator);
        return $this;
    } 
    
    /**
     * @param string $order 
     * 
     * @return \model\querys\UserGuardQuery
     */
    public function orderByUserId($order = Mysql::ASC) {
        $this->orderBy(UserGuard::FIELD_USER_GUARD_USER_ID, $order);
        return $this;
    }
    
    /**
     * 
     * @return \model\querys\UserGuardQuery
     */
    public function groupByUserId() {
        $this->groupBy(UserGuard::FIELD_USER_GUARD_USER_ID);
        return $this;
    }
    
    

    /**
     * 
     * @return \model\querys\UserGuardQuery
     */
    public function selectUsername() {
        $this->setSelect(UserGuard::FIELD_USER_GUARD_USERNAME);
        return $this;
    }
    
    /**
     * @param mixed $values 
     * @param string $operator SQL Operator
     * 
     * @return \model\querys\UserGuardQuery
     */
    public function filterByUsername($values, $operator = Mysql::EQUAL) {
        $this->filterByColumn(UserGuard::FIELD_USER_GUARD_USERNAME, $values, $operator);
        return $this;
    } 
    
    /**
     * @param string $order 
     * 
     * @return \model\querys\UserGuardQuery
     */
    public function orderByUsername($order = Mysql::ASC) {
        $this->orderBy(UserGuard::FIELD_USER_GUARD_USERNAME, $order);
        return $this;
    }
    
    /**
     * 
     * @return \model\querys\UserGuardQuery
     */
    public function groupByUsername() {
        $this->groupBy(UserGuard::FIELD_USER_GUARD_USERNAME);
        return $this;
    }
    
    

    /**
     * 
     * @return \model\querys\UserGuardQuery
     */
    public function selectSalt() {
        $this->setSelect(UserGuard::FIELD_USER_GUARD_SALT);
        return $this;
    }
    
    /**
     * @param mixed $values 
     * @param string $operator SQL Operator
     * 
     * @return \model\querys\UserGuardQuery
     */
    public function filterBySalt($values, $operator = Mysql::EQUAL) {
        $this->filterByColumn(UserGuard::FIELD_USER_GUARD_SALT, $values, $operator);
        return $this;
    } 
    
    /**
     * @param string $order 
     * 
     * @return \model\querys\UserGuardQuery
     */
    public function orderBySalt($order = Mysql::ASC) {
        $this->orderBy(UserGuard::FIELD_USER_GUARD_SALT, $order);
        return $this;
    }
    
    /**
     * 
     * @return \model\querys\UserGuardQuery
     */
    public function groupBySalt() {
        $this->groupBy(UserGuard::FIELD_USER_GUARD_SALT);
        return $this;
    }
    
    

    /**
     * 
     * @return \model\querys\UserGuardQuery
     */
    public function selectUserkey() {
        $this->setSelect(UserGuard::FIELD_USER_GUARD_USERKEY);
        return $this;
    }
    
    /**
     * @param mixed $values 
     * @param string $operator SQL Operator
     * 
     * @return \model\querys\UserGuardQuery
     */
    public function filterByUserkey($values, $operator = Mysql::EQUAL) {
        $this->filterByColumn(UserGuard::FIELD_USER_GUARD_USERKEY, $values, $operator);
        return $this;
    } 
    
    /**
     * @param string $order 
     * 
     * @return \model\querys\UserGuardQuery
     */
    public function orderByUserkey($order = Mysql::ASC) {
        $this->orderBy(UserGuard::FIELD_USER_GUARD_USERKEY, $order);
        return $this;
    }
    
    /**
     * 
     * @return \model\querys\UserGuardQuery
     */
    public function groupByUserkey() {
        $this->groupBy(UserGuard::FIELD_USER_GUARD_USERKEY);
        return $this;
    }
    
    
    
    
    
    /**
     * Makes join
     * @param Mysql $join
     *
     * @return \Model\querys\UserQuery
     */
    function joinUser($join = Mysql::INNER_JOIN) {
        $this->join(\Model\models\User::TABLE, $join, [UserGuard::FIELD_USER_GUARD_USER_ID, \Model\models\User::FIELD_USER_ID]);
        return \Model\querys\UserQuery::useModel($this);
    }
    
    

}
