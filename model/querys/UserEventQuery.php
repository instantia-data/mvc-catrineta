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

use \Model\models\UserEvent;
use \Catrineta\orm\mysql\Mysql;

/**
 * Description of UserEvent
 *
 * @author Luís Pinto / luis.nestesitio@gmail.com
 * Created @2017-09-22 17:25
 * Updated @Updated @2017-09-22 17:25 with columns id, name *
 */
class UserEventQuery extends \Catrineta\orm\query\QuerySelect {
    
    public static function start($merge = ALL){
        $obj = new UserEventQuery(new UserEvent(), $merge);
        $obj->startPrimary($merge);
        return $obj;
    }
    
    public static function useModel($merge){
        $obj = new UserEventQuery(new UserEvent());
        $obj->startJoin($merge);
        return $obj;
    }
    
    /**
     * Completes the join and return primary query,
     * because Netbeans we put child query on return, the program will get primary class function endUse()
     *
     * @return \model\querys\UserEventQuery
     */
    public function endUse(){
        return parent::completeMerge();
    }
    
    
    /**
     * Completes query and return a collection of UserEvent objects
     *
     * @return \model\models\UserEvent[]
     */
    public function find() {
        return parent::find();
    }
    
    /**
     * Completes query with limit 1.
     *
     * @return \model\models\UserEvent
     */
    public function findOne(){
        return parent::findOne();
    }
    
    /**
     * Completes query. If result is 0 create object
     *
     * @return \model\models\UserEvent
     */
    public function findOneOrCreate(){
        return parent::findOneOrCreate();
    }
    
    

    /**
     * 
     * @return \model\querys\UserEventQuery
     */
    public function selectId() {
        $this->setSelect(UserEvent::FIELD_USER_EVENT_ID);
        return $this;
    }
    
    /**
     * @param mixed $values 
     * @param string $operator SQL Operator
     * 
     * @return \model\querys\UserEventQuery
     */
    public function filterById($values, $operator = Mysql::EQUAL) {
        $this->filterByColumn(UserEvent::FIELD_USER_EVENT_ID, $values, $operator);
        return $this;
    } 
    
    /**
     * @param string $order 
     * 
     * @return \model\querys\UserEventQuery
     */
    public function orderById($order = Mysql::ASC) {
        $this->orderBy(UserEvent::FIELD_USER_EVENT_ID, $order);
        return $this;
    }
    
    /**
     * 
     * @return \model\querys\UserEventQuery
     */
    public function groupById() {
        $this->groupBy(UserEvent::FIELD_USER_EVENT_ID);
        return $this;
    }
    
    

    /**
     * 
     * @return \model\querys\UserEventQuery
     */
    public function selectName() {
        $this->setSelect(UserEvent::FIELD_USER_EVENT_NAME);
        return $this;
    }
    
    /**
     * @param mixed $values 
     * @param string $operator SQL Operator
     * 
     * @return \model\querys\UserEventQuery
     */
    public function filterByName($values, $operator = Mysql::EQUAL) {
        $this->filterByColumn(UserEvent::FIELD_USER_EVENT_NAME, $values, $operator);
        return $this;
    } 
    
    /**
     * @param string $order 
     * 
     * @return \model\querys\UserEventQuery
     */
    public function orderByName($order = Mysql::ASC) {
        $this->orderBy(UserEvent::FIELD_USER_EVENT_NAME, $order);
        return $this;
    }
    
    /**
     * 
     * @return \model\querys\UserEventQuery
     */
    public function groupByName() {
        $this->groupBy(UserEvent::FIELD_USER_EVENT_NAME);
        return $this;
    }
    
    
    
    
    
    /**
     * Makes join
     * @param Mysql $join
     *
     * @return \Model\querys\UserLogQuery
     */
    function joinUserLog($join = Mysql::INNER_JOIN) {
        $this->join(\Model\models\UserLog::TABLE, $join, [UserEvent::FIELD_USER_EVENT_ID, \Model\models\UserLog::FIELD_USER_LOG_USER_EVENT]);
        return \Model\querys\UserLogQuery::useModel($this);
    }
    
    

}
