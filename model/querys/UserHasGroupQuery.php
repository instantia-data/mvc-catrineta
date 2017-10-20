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

use \Model\models\UserHasGroup;
use \Catrineta\db\Sql;

/**
 * Description of UserHasGroup
 *
 * @author Luís Pinto / luis.nestesitio@gmail.com
 * Created @2017-10-20 17:13
 * Updated @Updated @2017-10-20 17:13 with columns user_id, user_group *
 */
class UserHasGroupQuery extends \Catrineta\orm\query\QuerySelect {
    
    /**
     * 
     * @param string $merge Possible values: ALL the columns | ONLY the id | false columns
     * @param string $alias Alias for the table
     * @return \model\querys\UserHasGroupQuery
     */
    public static function init($merge = ALL, $alias = null){
        $obj = new UserHasGroupQuery(new UserHasGroup(), $alias);
        $obj->setAllSelects($merge);
        return $obj;
    }
    
    /**
     * Used to merge query classes on join tables
     * @param \Catrineta\orm\query\QuerySelect $merge The primary class
     * @return \model\querys\UserHasGroupQuery
     */
    public static function useModel(\Catrineta\orm\query\QuerySelect $merge){
        $obj = new UserHasGroupQuery(new UserHasGroup());
        $obj->startJoin($merge);
        return $obj;
    }
    
    /**
     * Completes the join and return primary query,
     * because Netbeans we put child query on return, the program will get primary class function endUse()
     *
     * @return \model\querys\UserHasGroupQuery
     */
    public function endUse(){
        return parent::completeMerge();
    }
    
    
    /**
     * Completes query and return a collection of UserHasGroup objects
     *
     * @return \model\models\UserHasGroup[]
     */
    public function find() {
        return parent::find();
    }
    
    /**
     * Completes query with limit 1.
     *
     * @return \model\models\UserHasGroup
     */
    public function findOne(){
        return parent::findOne();
    }
    
    /**
     * Completes query. If result is 0 create object
     *
     * @return \model\models\UserHasGroup
     */
    public function findOneOrCreate(){
        return parent::findOneOrCreate();
    }
    
    

    /**
     * 
     * @return \model\querys\UserHasGroupQuery
     */
    public function selectUserId($alias = null) {
        $this->setSelect(UserHasGroup::FIELD_USER_HAS_GROUP_USER_ID, $alias);
        return $this;
    }
    
    /**
     * @param mixed $values 
     * @param string $operator SQL Operator
     * 
     * @return \model\querys\UserHasGroupQuery
     */
    public function filterByUserId($values, $operator = Sql::EQUAL) {
        $this->filterByColumn(UserHasGroup::FIELD_USER_HAS_GROUP_USER_ID, $values, $operator);
        return $this;
    } 
    
    /**
     * 
     * @return \model\querys\UserHasGroupQuery
     */
    public function groupByUserId() {
        $this->groupBy(UserHasGroup::FIELD_USER_HAS_GROUP_USER_ID);
        return $this;
    }
    
    /**
     * @param string $order (ASC | DESC)
     * 
     * @return \model\querys\UserHasGroupQuery
     */
    public function orderByUserId($order = Sql::ASC) {
        $this->orderBy(UserHasGroup::FIELD_USER_HAS_GROUP_USER_ID, $order);
        return $this;
    }
    
    

    /**
     * 
     * @return \model\querys\UserHasGroupQuery
     */
    public function selectUserGroup($alias = null) {
        $this->setSelect(UserHasGroup::FIELD_USER_HAS_GROUP_USER_GROUP, $alias);
        return $this;
    }
    
    /**
     * @param mixed $values 
     * @param string $operator SQL Operator
     * 
     * @return \model\querys\UserHasGroupQuery
     */
    public function filterByUserGroup($values, $operator = Sql::EQUAL) {
        $this->filterByColumn(UserHasGroup::FIELD_USER_HAS_GROUP_USER_GROUP, $values, $operator);
        return $this;
    } 
    
    /**
     * 
     * @return \model\querys\UserHasGroupQuery
     */
    public function groupByUserGroup() {
        $this->groupBy(UserHasGroup::FIELD_USER_HAS_GROUP_USER_GROUP);
        return $this;
    }
    
    /**
     * @param string $order (ASC | DESC)
     * 
     * @return \model\querys\UserHasGroupQuery
     */
    public function orderByUserGroup($order = Sql::ASC) {
        $this->orderBy(UserHasGroup::FIELD_USER_HAS_GROUP_USER_GROUP, $order);
        return $this;
    }
    
    
    
    
    
    /**
     * Makes join
     * @param Mysql $join
     *
     * @return \Model\querys\UserGroupQuery
     */
    function joinUserGroup($join = Sql::INNER_JOIN, $alias = null) {
        $this->join(\Model\models\UserGroup::TABLE, $join, UserHasGroup::FIELD_USER_HAS_GROUP_USER_GROUP, \Model\models\UserGroup::FIELD_USER_GROUP_ID, $alias);
        return \Model\querys\UserGroupQuery::useModel($this);
    }
    
    
    
    /**
     * Makes join
     * @param Mysql $join
     *
     * @return \Model\querys\UserQuery
     */
    function joinUser($join = Sql::INNER_JOIN, $alias = null) {
        $this->join(\Model\models\User::TABLE, $join, UserHasGroup::FIELD_USER_HAS_GROUP_USER_ID, \Model\models\User::FIELD_USER_ID, $alias);
        return \Model\querys\UserQuery::useModel($this);
    }
    
    

}
