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

use \Model\models\UserGroup;
use \Catrineta\db\Sql;

/**
 * Description of UserGroup
 *
 * @author Luís Pinto / luis.nestesitio@gmail.com
 * Created @2017-10-20 17:13
 * Updated @Updated @2017-10-20 17:13 with columns id, name, description *
 */
class UserGroupQuery extends \Catrineta\orm\query\QuerySelect {
    
    /**
     * 
     * @param string $merge Possible values: ALL the columns | ONLY the id | false columns
     * @param string $alias Alias for the table
     * @return \model\querys\UserGroupQuery
     */
    public static function init($merge = ALL, $alias = null){
        $obj = new UserGroupQuery(new UserGroup(), $alias);
        $obj->setAllSelects($merge);
        return $obj;
    }
    
    /**
     * Used to merge query classes on join tables
     * @param \Catrineta\orm\query\QuerySelect $merge The primary class
     * @return \model\querys\UserGroupQuery
     */
    public static function useModel(\Catrineta\orm\query\QuerySelect $merge){
        $obj = new UserGroupQuery(new UserGroup());
        $obj->startJoin($merge);
        return $obj;
    }
    
    /**
     * Completes the join and return primary query,
     * because Netbeans we put child query on return, the program will get primary class function endUse()
     *
     * @return \model\querys\UserGroupQuery
     */
    public function endUse(){
        return parent::completeMerge();
    }
    
    
    /**
     * Completes query and return a collection of UserGroup objects
     *
     * @return \model\models\UserGroup[]
     */
    public function find() {
        return parent::find();
    }
    
    /**
     * Completes query with limit 1.
     *
     * @return \model\models\UserGroup
     */
    public function findOne(){
        return parent::findOne();
    }
    
    /**
     * Completes query. If result is 0 create object
     *
     * @return \model\models\UserGroup
     */
    public function findOneOrCreate(){
        return parent::findOneOrCreate();
    }
    
    

    /**
     * 
     * @return \model\querys\UserGroupQuery
     */
    public function selectId($alias = null) {
        $this->setSelect(UserGroup::FIELD_USER_GROUP_ID, $alias);
        return $this;
    }
    
    /**
     * @param mixed $values 
     * @param string $operator SQL Operator
     * 
     * @return \model\querys\UserGroupQuery
     */
    public function filterById($values, $operator = Sql::EQUAL) {
        $this->filterByColumn(UserGroup::FIELD_USER_GROUP_ID, $values, $operator);
        return $this;
    } 
    
    /**
     * 
     * @return \model\querys\UserGroupQuery
     */
    public function groupById() {
        $this->groupBy(UserGroup::FIELD_USER_GROUP_ID);
        return $this;
    }
    
    /**
     * @param string $order (ASC | DESC)
     * 
     * @return \model\querys\UserGroupQuery
     */
    public function orderById($order = Sql::ASC) {
        $this->orderBy(UserGroup::FIELD_USER_GROUP_ID, $order);
        return $this;
    }
    
    

    /**
     * 
     * @return \model\querys\UserGroupQuery
     */
    public function selectName($alias = null) {
        $this->setSelect(UserGroup::FIELD_USER_GROUP_NAME, $alias);
        return $this;
    }
    
    /**
     * @param mixed $values 
     * @param string $operator SQL Operator
     * 
     * @return \model\querys\UserGroupQuery
     */
    public function filterByName($values, $operator = Sql::EQUAL) {
        $this->filterByColumn(UserGroup::FIELD_USER_GROUP_NAME, $values, $operator);
        return $this;
    } 
    
    /**
     * 
     * @return \model\querys\UserGroupQuery
     */
    public function groupByName() {
        $this->groupBy(UserGroup::FIELD_USER_GROUP_NAME);
        return $this;
    }
    
    /**
     * @param string $order (ASC | DESC)
     * 
     * @return \model\querys\UserGroupQuery
     */
    public function orderByName($order = Sql::ASC) {
        $this->orderBy(UserGroup::FIELD_USER_GROUP_NAME, $order);
        return $this;
    }
    
    

    /**
     * 
     * @return \model\querys\UserGroupQuery
     */
    public function selectDescription($alias = null) {
        $this->setSelect(UserGroup::FIELD_USER_GROUP_DESCRIPTION, $alias);
        return $this;
    }
    
    /**
     * @param mixed $values 
     * @param string $operator SQL Operator
     * 
     * @return \model\querys\UserGroupQuery
     */
    public function filterByDescription($values, $operator = Sql::EQUAL) {
        $this->filterByColumn(UserGroup::FIELD_USER_GROUP_DESCRIPTION, $values, $operator);
        return $this;
    } 
    
    /**
     * 
     * @return \model\querys\UserGroupQuery
     */
    public function groupByDescription() {
        $this->groupBy(UserGroup::FIELD_USER_GROUP_DESCRIPTION);
        return $this;
    }
    
    /**
     * @param string $order (ASC | DESC)
     * 
     * @return \model\querys\UserGroupQuery
     */
    public function orderByDescription($order = Sql::ASC) {
        $this->orderBy(UserGroup::FIELD_USER_GROUP_DESCRIPTION, $order);
        return $this;
    }
    
    
    
    
    
    /**
     * Makes join
     * @param Mysql $join
     *
     * @return \Model\querys\UserHasGroupQuery
     */
    function joinUserHasGroup($join = Sql::INNER_JOIN, $alias = null) {
        $this->join(\Model\models\UserHasGroup::TABLE, $join, UserGroup::FIELD_USER_GROUP_ID, \Model\models\UserHasGroup::FIELD_USER_HAS_GROUP_USER_GROUP, $alias);
        return \Model\querys\UserHasGroupQuery::useModel($this);
    }
    
    

}
