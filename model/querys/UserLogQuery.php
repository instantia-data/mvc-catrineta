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

use \Model\models\UserLog;
use \Catrineta\orm\mysql\Mysql;

/**
 * Description of UserLog
 *
 * @author Luís Pinto / luis.nestesitio@gmail.com
 * Created @2017-09-22 17:25
 * Updated @Updated @2017-09-22 17:25 with columns id, user_id, user_event, timestamp *
 */
class UserLogQuery extends \Catrineta\orm\query\QuerySelect {
    
    public static function start($merge = ALL){
        $obj = new UserLogQuery(new UserLog(), $merge);
        $obj->startPrimary($merge);
        return $obj;
    }
    
    public static function useModel($merge){
        $obj = new UserLogQuery(new UserLog());
        $obj->startJoin($merge);
        return $obj;
    }
    
    /**
     * Completes the join and return primary query,
     * because Netbeans we put child query on return, the program will get primary class function endUse()
     *
     * @return \model\querys\UserLogQuery
     */
    public function endUse(){
        return parent::completeMerge();
    }
    
    
    /**
     * Completes query and return a collection of UserLog objects
     *
     * @return \model\models\UserLog[]
     */
    public function find() {
        return parent::find();
    }
    
    /**
     * Completes query with limit 1.
     *
     * @return \model\models\UserLog
     */
    public function findOne(){
        return parent::findOne();
    }
    
    /**
     * Completes query. If result is 0 create object
     *
     * @return \model\models\UserLog
     */
    public function findOneOrCreate(){
        return parent::findOneOrCreate();
    }
    
    

    /**
     * 
     * @return \model\querys\UserLogQuery
     */
    public function selectId() {
        $this->setSelect(UserLog::FIELD_USER_LOG_ID);
        return $this;
    }
    
    /**
     * @param mixed $values 
     * @param string $operator SQL Operator
     * 
     * @return \model\querys\UserLogQuery
     */
    public function filterById($values, $operator = Mysql::EQUAL) {
        $this->filterByColumn(UserLog::FIELD_USER_LOG_ID, $values, $operator);
        return $this;
    } 
    
    /**
     * @param string $order 
     * 
     * @return \model\querys\UserLogQuery
     */
    public function orderById($order = Mysql::ASC) {
        $this->orderBy(UserLog::FIELD_USER_LOG_ID, $order);
        return $this;
    }
    
    /**
     * 
     * @return \model\querys\UserLogQuery
     */
    public function groupById() {
        $this->groupBy(UserLog::FIELD_USER_LOG_ID);
        return $this;
    }
    
    

    /**
     * 
     * @return \model\querys\UserLogQuery
     */
    public function selectUserId() {
        $this->setSelect(UserLog::FIELD_USER_LOG_USER_ID);
        return $this;
    }
    
    /**
     * @param mixed $values 
     * @param string $operator SQL Operator
     * 
     * @return \model\querys\UserLogQuery
     */
    public function filterByUserId($values, $operator = Mysql::EQUAL) {
        $this->filterByColumn(UserLog::FIELD_USER_LOG_USER_ID, $values, $operator);
        return $this;
    } 
    
    /**
     * @param string $order 
     * 
     * @return \model\querys\UserLogQuery
     */
    public function orderByUserId($order = Mysql::ASC) {
        $this->orderBy(UserLog::FIELD_USER_LOG_USER_ID, $order);
        return $this;
    }
    
    /**
     * 
     * @return \model\querys\UserLogQuery
     */
    public function groupByUserId() {
        $this->groupBy(UserLog::FIELD_USER_LOG_USER_ID);
        return $this;
    }
    
    

    /**
     * 
     * @return \model\querys\UserLogQuery
     */
    public function selectUserEvent() {
        $this->setSelect(UserLog::FIELD_USER_LOG_USER_EVENT);
        return $this;
    }
    
    /**
     * @param mixed $values 
     * @param string $operator SQL Operator
     * 
     * @return \model\querys\UserLogQuery
     */
    public function filterByUserEvent($values, $operator = Mysql::EQUAL) {
        $this->filterByColumn(UserLog::FIELD_USER_LOG_USER_EVENT, $values, $operator);
        return $this;
    } 
    
    /**
     * @param string $order 
     * 
     * @return \model\querys\UserLogQuery
     */
    public function orderByUserEvent($order = Mysql::ASC) {
        $this->orderBy(UserLog::FIELD_USER_LOG_USER_EVENT, $order);
        return $this;
    }
    
    /**
     * 
     * @return \model\querys\UserLogQuery
     */
    public function groupByUserEvent() {
        $this->groupBy(UserLog::FIELD_USER_LOG_USER_EVENT);
        return $this;
    }
    
    

    /**
     * 
     * @return \model\querys\UserLogQuery
     */
    public function selectTimestamp() {
        $this->setSelect(UserLog::FIELD_USER_LOG_TIMESTAMP);
        return $this;
    }
    
    /**
     * @param mixed $values 
     * @param string $operator SQL Operator
     * 
     * @return \model\querys\UserLogQuery
     */
    public function filterByTimestamp($values, $operator = Mysql::EQUAL) {
        $this->filterByColumn(UserLog::FIELD_USER_LOG_TIMESTAMP, $values, $operator);
        return $this;
    } 
    
    /**
     * @param string $order 
     * 
     * @return \model\querys\UserLogQuery
     */
    public function orderByTimestamp($order = Mysql::ASC) {
        $this->orderBy(UserLog::FIELD_USER_LOG_TIMESTAMP, $order);
        return $this;
    }
    
    /**
     * 
     * @return \model\querys\UserLogQuery
     */
    public function groupByTimestamp() {
        $this->groupBy(UserLog::FIELD_USER_LOG_TIMESTAMP);
        return $this;
    }
    
    
    
    
    
    /**
     * Makes join
     * @param Mysql $join
     *
     * @return \Model\querys\UserEventQuery
     */
    function joinUserEvent($join = Mysql::INNER_JOIN) {
        $this->join(\Model\models\UserEvent::TABLE, $join, [UserLog::FIELD_USER_LOG_USER_EVENT, \Model\models\UserEvent::FIELD_USER_EVENT_ID]);
        return \Model\querys\UserEventQuery::useModel($this);
    }
    
    
    
    /**
     * Makes join
     * @param Mysql $join
     *
     * @return \Model\querys\UserQuery
     */
    function joinUser($join = Mysql::INNER_JOIN) {
        $this->join(\Model\models\User::TABLE, $join, [UserLog::FIELD_USER_LOG_USER_ID, \Model\models\User::FIELD_USER_ID]);
        return \Model\querys\UserQuery::useModel($this);
    }
    
    

}
