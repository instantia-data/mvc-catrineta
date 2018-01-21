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

use \Model\models\UserLog;
use \Catrineta\db\Sql;

/**
 * Description of UserLog
 *
 * @author Luís Pinto / luis.nestesitio@gmail.com
 * Created @2018-01-19 18:03
 * Updated @Updated @2018-01-19 18:03 with columns id, user_id, user_event, timestamp *
 */
class UserLogQuery extends \Catrineta\orm\query\QuerySelect {
    
    /**
     * 
     * @param string $merge Possible values: ALL the columns | ONLY the id | false columns
     * @param string $alias Alias for the table
     * @return \Model\querys\UserLogQuery
     */
    public static function init($merge = ALL, $alias = null){
        $obj = new UserLogQuery(new UserLog(), $alias);
        $obj->setAllSelects($merge);
        return $obj;
    }
    
    /**
     * Used to merge query classes on join tables
     * @param \Catrineta\orm\query\QuerySelect $merge The primary class
     * @return \Model\querys\UserLogQuery
     */
    public static function useModel(\Catrineta\orm\query\QuerySelect $merge){
        $obj = new UserLogQuery(new UserLog());
        $obj->startJoin($merge);
        return $obj;
    }
    
    /**
     * Completes the join and return primary query,
     * because Netbeans we put child query on return, the program will get primary class function endUse()
     *
     * @return \Model\querys\UserLogQuery
     */
    public function endUse(){
        return parent::completeMerge();
    }
    
    
    /**
     * Completes query and return a collection of UserLog objects
     *
     * @return \Model\models\UserLog[]
     */
    public function find() {
        return parent::find();
    }
    
    /**
     * Completes query with limit 1.
     *
     * @return \Model\models\UserLog
     */
    public function findOne(){
        return parent::findOne();
    }
    
    /**
     * Completes query. If result is 0 create object
     *
     * @return \Model\models\UserLog
     */
    public function findOneOrCreate(){
        return parent::findOneOrCreate();
    }
    
    

    /**
     * 
     * @return \Model\querys\UserLogQuery
     */
    public function selectId($alias = null) {
        $this->setSelect(UserLog::FIELD_USER_LOG_ID, $alias);
        return $this;
    }
    
    /**
     * @param mixed $values 
     * @param string $operator SQL Operator
     * 
     * @return \Model\querys\UserLogQuery
     */
    public function filterById($values, $operator = Sql::EQUAL) {
        $this->filterByColumn(UserLog::FIELD_USER_LOG_ID, $values, $operator);
        return $this;
    } 
    
    /**
     * 
     * @return \Model\querys\UserLogQuery
     */
    public function groupById() {
        $this->groupBy(UserLog::FIELD_USER_LOG_ID);
        return $this;
    }
    
    /**
     * @param string $order (ASC | DESC)
     * 
     * @return \Model\querys\UserLogQuery
     */
    public function orderById($order = Sql::ASC) {
        $this->orderBy(UserLog::FIELD_USER_LOG_ID, $order);
        return $this;
    }
    
    

    /**
     * 
     * @return \Model\querys\UserLogQuery
     */
    public function selectUserId($alias = null) {
        $this->setSelect(UserLog::FIELD_USER_LOG_USER_ID, $alias);
        return $this;
    }
    
    /**
     * @param mixed $values 
     * @param string $operator SQL Operator
     * 
     * @return \Model\querys\UserLogQuery
     */
    public function filterByUserId($values, $operator = Sql::EQUAL) {
        $this->filterByColumn(UserLog::FIELD_USER_LOG_USER_ID, $values, $operator);
        return $this;
    } 
    
    /**
     * 
     * @return \Model\querys\UserLogQuery
     */
    public function groupByUserId() {
        $this->groupBy(UserLog::FIELD_USER_LOG_USER_ID);
        return $this;
    }
    
    /**
     * @param string $order (ASC | DESC)
     * 
     * @return \Model\querys\UserLogQuery
     */
    public function orderByUserId($order = Sql::ASC) {
        $this->orderBy(UserLog::FIELD_USER_LOG_USER_ID, $order);
        return $this;
    }
    
    

    /**
     * 
     * @return \Model\querys\UserLogQuery
     */
    public function selectUserEvent($alias = null) {
        $this->setSelect(UserLog::FIELD_USER_LOG_USER_EVENT, $alias);
        return $this;
    }
    
    /**
     * @param mixed $values 
     * @param string $operator SQL Operator
     * 
     * @return \Model\querys\UserLogQuery
     */
    public function filterByUserEvent($values, $operator = Sql::EQUAL) {
        $this->filterByColumn(UserLog::FIELD_USER_LOG_USER_EVENT, $values, $operator);
        return $this;
    } 
    
    /**
     * 
     * @return \Model\querys\UserLogQuery
     */
    public function groupByUserEvent() {
        $this->groupBy(UserLog::FIELD_USER_LOG_USER_EVENT);
        return $this;
    }
    
    /**
     * @param string $order (ASC | DESC)
     * 
     * @return \Model\querys\UserLogQuery
     */
    public function orderByUserEvent($order = Sql::ASC) {
        $this->orderBy(UserLog::FIELD_USER_LOG_USER_EVENT, $order);
        return $this;
    }
    
    

    /**
     * 
     * @return \Model\querys\UserLogQuery
     */
    public function selectTimestamp($alias = null) {
        $this->setSelect(UserLog::FIELD_USER_LOG_TIMESTAMP, $alias);
        return $this;
    }
    
    /**
     * @param mixed $values 
     * @param string $operator SQL Operator
     * 
     * @return \Model\querys\UserLogQuery
     */
    public function filterByTimestamp($values, $operator = Sql::EQUAL) {
        $this->filterByDateColumn(UserLog::FIELD_USER_LOG_TIMESTAMP, $values, $operator);
        return $this;
    } 
    
    /**
     * 
     * @return \Model\querys\UserLogQuery
     */
    public function groupByTimestamp() {
        $this->groupBy(UserLog::FIELD_USER_LOG_TIMESTAMP);
        return $this;
    }
    
    /**
     * @param string $order (ASC | DESC)
     * 
     * @return \Model\querys\UserLogQuery
     */
    public function orderByTimestamp($order = Sql::ASC) {
        $this->orderBy(UserLog::FIELD_USER_LOG_TIMESTAMP, $order);
        return $this;
    }
    
    
    
    
    
    /**
     * Makes join
     * @param Mysql $join
     *
     * @return \Model\querys\UserEventQuery
     */
    function joinUserEvent($join = Sql::INNER_JOIN, $alias = null) {
        $this->join(\Model\models\UserEvent::TABLE, $join, UserLog::FIELD_USER_LOG_USER_EVENT, \Model\models\UserEvent::FIELD_USER_EVENT_ID, $alias);
        return \Model\querys\UserEventQuery::useModel($this);
    }
    
    
    
    /**
     * Makes join
     * @param Mysql $join
     *
     * @return \Model\querys\UserQuery
     */
    function joinUser($join = Sql::INNER_JOIN, $alias = null) {
        $this->join(\Model\models\User::TABLE, $join, UserLog::FIELD_USER_LOG_USER_ID, \Model\models\User::FIELD_USER_ID, $alias);
        return \Model\querys\UserQuery::useModel($this);
    }
    
    

}
