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

use \Model\models\%$className%;
use \Catrineta\db\mysql\Mysql;

/**
 * Description of %$className%
 *
 * @author Luís Pinto / luis.nestesitio@gmail.com
 * Created @%$dateCreated%
 * Updated @%$dateUpdated% *
 */
class %$className%Query extends \Catrineta\orm\query\QuerySelect {
    
    public static function start($merge = ALL){
        $obj = new %$className%Query(new %$className%(), $merge);
        $obj->startPrimary($merge);
        return $obj;
    }
    
    public static function useModel($merge){
        $obj = new %$className%Query(new %$className%());
        $obj->startJoin($merge);
        return $obj;
    }
    
    /**
     * Completes the join and return primary query,
     * because Netbeans we put child query on return, the program will get primary class function endUse()
     *
     * @return \model\querys\%$className%Query
     */
    public function endUse(){
        return parent::completeMerge();
    }
    
    
    /**
     * Completes query and return a collection of %$className% objects
     *
     * @return \model\models\%$className%[]
     */
    public function find() {
        return parent::find();
    }
    
    /**
     * Completes query with limit 1.
     *
     * @return \model\models\%$className%
     */
    public function findOne(){
        return parent::findOne();
    }
    
    /**
     * Completes query. If result is 0 create object
     *
     * @return \model\models\%$className%
     */
    public function findOneOrCreate(){
        return parent::findOneOrCreate();
    }
    
    {@while ($item in columns):}

    /**
     * 
     * @return \model\querys\%$className%Query
     */
    public function select{$item.method}() {
        $this->setSelect({$item.field});
        return $this;
    }
    
    /**
     * @param mixed $values 
     * @param string $operator SQL Operator
     * 
     * @return \model\querys\%$className%Query
     */
    public function filterBy{$item.method}($values, $operator = Mysql::EQUAL) {
        $this->filterByColumn({$item.field}, $values, $operator);
        return $this;
    } 
    
    /**
     * @param string $order 
     * 
     * @return \model\querys\%$className%Query
     */
    public function orderBy{$item.method}($order = Mysql::ASC) {
        $this->orderBy({$item.field}, $order);
        return $this;
    }
    
    /**
     * 
     * @return \model\querys\%$className%Query
     */
    public function groupBy{$item.method}() {
        $this->groupBy({$item.field});
        return $this;
    }
    
    {@endwhile;}
    
    {@while ($item in joins):}
    
    /**
     * Makes join
     * @param Mysql $join
     *
     * @return \Model\querys\{$item.tablejoin}Query
     */
    function join{$item.tablejoin}($join = Mysql::INNER_JOIN) {
        $this->join(\Model\models\{$item.tablejoin}::TABLE, $join, [{$item.leftcol}, \Model\models\{$item.rightcol}]);
        return \Model\querys\{$item.tablejoin}Query::useModel($this);
    }
    
    {@endwhile;}

}
