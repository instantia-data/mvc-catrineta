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

use \Model\models\UserStatus;
use \Catrineta\db\Sql;

/**
 * Description of UserStatus
 *
 * @author Luís Pinto / luis.nestesitio@gmail.com
 * Created @%$dateCreated%
 * Updated @%$dateUpdated% *
 */
class UserStatusQuery extends \Catrineta\orm\query\QuerySelect {
    
    /**
     * 
     * @param string $merge Possible values: ALL the columns | ONLY the id | false columns
     * @param string $alias Alias for the table
     * @return \Model\querys\UserStatusQuery
     */
    public static function init($merge = ALL, $alias = null){
        $obj = new UserStatusQuery(new UserStatus(), $alias);
        $obj->setAllSelects($merge);
        return $obj;
    }
    
    /**
     * Used to merge query classes on join tables
     * @param \Catrineta\orm\query\QuerySelect $merge The primary class
     * @return \Model\querys\UserStatusQuery
     */
    public static function useModel(\Catrineta\orm\query\QuerySelect $merge){
        $obj = new UserStatusQuery(new UserStatus());
        $obj->startJoin($merge);
        return $obj;
    }
    
    /**
     * Completes the join and return primary query,
     * because Netbeans we put child query on return, the program will get primary class function endUse()
     *
     * @return \Model\querys\UserStatusQuery
     */
    public function endUse(){
        return parent::completeMerge();
    }
    
    
    /**
     * Completes query and return a collection of UserStatus objects
     *
     * @return \Model\models\UserStatus[]
     */
    public function find() {
        return parent::find();
    }
    
    /**
     * Completes query with limit 1.
     *
     * @return \Model\models\UserStatus
     */
    public function findOne(){
        return parent::findOne();
    }
    
    /**
     * Completes query. If result is 0 create object
     *
     * @return \Model\models\UserStatus
     */
    public function findOneOrCreate(){
        return parent::findOneOrCreate();
    }
    
    

    /**
     * 
     * @return \Model\querys\UserStatusQuery
     */
    public function selectId($alias = null) {
        $this->setSelect(UserStatus::FIELD_USER_STATUS_ID, $alias);
        return $this;
    }
    
    /**
     * @param mixed $values 
     * @param string $operator SQL Operator
     * 
     * @return \Model\querys\UserStatusQuery
     */
    public function filterById($values, $operator = Sql::EQUAL) {
        $this->filterByColumn(UserStatus::FIELD_USER_STATUS_ID, $values, $operator);
        return $this;
    } 
    
    /**
     * 
     * @return \Model\querys\UserStatusQuery
     */
    public function groupById() {
        $this->groupBy(UserStatus::FIELD_USER_STATUS_ID);
        return $this;
    }
    
    /**
     * @param string $order (ASC | DESC)
     * 
     * @return \Model\querys\UserStatusQuery
     */
    public function orderById($order = Sql::ASC) {
        $this->orderBy(UserStatus::FIELD_USER_STATUS_ID, $order);
        return $this;
    }
    
    

    /**
     * 
     * @return \Model\querys\UserStatusQuery
     */
    public function selectName($alias = null) {
        $this->setSelect(UserStatus::FIELD_USER_STATUS_NAME, $alias);
        return $this;
    }
    
    /**
     * @param mixed $values 
     * @param string $operator SQL Operator
     * 
     * @return \Model\querys\UserStatusQuery
     */
    public function filterByName($values, $operator = Sql::EQUAL) {
        $this->filterByColumn(UserStatus::FIELD_USER_STATUS_NAME, $values, $operator);
        return $this;
    } 
    
    /**
     * 
     * @return \Model\querys\UserStatusQuery
     */
    public function groupByName() {
        $this->groupBy(UserStatus::FIELD_USER_STATUS_NAME);
        return $this;
    }
    
    /**
     * @param string $order (ASC | DESC)
     * 
     * @return \Model\querys\UserStatusQuery
     */
    public function orderByName($order = Sql::ASC) {
        $this->orderBy(UserStatus::FIELD_USER_STATUS_NAME, $order);
        return $this;
    }
    
    
    
    
    
    /**
     * Makes join
     * @param Mysql $join
     *
     * @return \Model\querys\UserQuery
     */
    function joinUser($join = Sql::INNER_JOIN, $alias = null) {
        $this->join(\Model\models\User::TABLE, $join, UserStatus::FIELD_USER_STATUS_ID, \Model\models\User::FIELD_USER_USER_STATUS, $alias);
        return \Model\querys\UserQuery::useModel($this);
    }
    
    

}
