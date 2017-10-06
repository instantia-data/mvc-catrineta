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

namespace Catrineta\db\mysql;

use \Catrineta\db\mysql\MysqlStatement;

/**
 * Description of MysqlSelect
 *
 * @author Luís Pinto / luis.nestesitio@gmail.com
 * Created @Oct 6, 2017
 */
class MysqlSelect extends MysqlStatement
{


    /**
     * @return string Mysql statement
     */
    public function getStatementString()
    {
        if(count($this->selects) > 0){
            $statement['select_expr'] = implode(', ', $this->selects);
        }
        if($this->table != null){
            $statement['table'] = 'FROM ' . $this->table;
            if($this->table_alias != $this->table){
                $statement['table'] = ' AS ' . $this->table_alias;
            }
        }
        if(count($this->joins) > 0){
            $statement['joins'] = implode(' ', $this->joins);
        }
        if(count($this->wheres) > 0){
            $statement['wheres'] = 'WHERE ' . implode(' AND ', $this->wheres);
        }
        if(count($this->groups) > 0){
            $statement['group_condition'] = 'GROUP BY ' . implode(', ', $this->groups);
        }
        if(count($this->havings) > 0){
            $statement['having_condition'] = 'HAVING ' . implode(', ', $this->havings);
        }
        if(count($this->orders) > 0){
            $statement['orders'] = 'ORDER BY ' . implode(', ', $this->orders);
        }
        if(count($this->limit) > 0){
            $statement['limit'] = 'LIMIT ' . $this->limit[0];
        }
        #echo implode(' ', $statement) . '<hr />';
        return 'SELECT SQL_CALC_FOUND_ROWS ' . implode(' ', $statement);
    }
    
    
    /**
     * 
     * @param string $column
     * @param string $alias
     * @return $this
     */
    public function setSelect($column, $alias = null)
    {
        $str = $this->getColumnAliased($column);
        if(null != $alias){
            $str .= ' AS ' . $alias;
        }
        $this->selects[] = $str;
        return $this;
    }
    
    /**
     * 
     * @param array $columns
     * @return $this
     */
    public function setSelects($columns = [])
    {
        foreach($columns as $column){
            $this->setSelect($column);
        }
        return $this;
    }
    
    /**
     * @param $column
     * @param $alias
     */
    public function setDistinct($column, $alias = null)
    {
        $column = $this->getColumnAliased($column);
        $this->selects[] = (null != $alias)? 'DISTINCT ' . $column . ' AS '. $alias : 'DISTINCT ' . $column;

    }

    /**
     * @param $column
     * @param $alias
     */
    public function countDistinct($column, $alias = null)
    {
        $column = $this->getColumnAliased($column);
        $this->selects[] = (null != $alias)? 'COUNT(DISTINCT ' . $column . ') AS '. $alias : 'COUNT(DISTINCT ' . $column . ')';

    }
    
    
    protected $joins = [];
    
    
    /**
     * 
     * @param string $table The table to join
     * @param string $left Left column
     * @param string $right Right column
     * @param string $join Mysql clause INNER, LEFT or RIGHT JOIN
     * @param string $alias
     * @return $this
     */
    public function setJoin($table, $left, $right, $join = Mysql::INNER_JOIN, $alias = null)
    {
        
        $this->alias = ($alias == null)? $table : $alias;
        
        $str = $join . ' ' . $table . ' ';
        if(null != $alias){
            $str .= 'AS ' . $alias . ' ';
        }
        $str .= 'ON ' . $this->table_alias . '.' . $left . '=' . $this->alias . '.' . $right;
        
        
        $this->join[$alias] = $str;
        return $this;
    }
    
    /**
     * 
     * @param string $table The table of join
     * @param string $column The table column
     * @param mixed $value
     * @param string $operator
     * @return $this
     */
    public function addJoinCondition($table, $column, $value, $operator = Mysql::EQUAL)
    {
        $str = ' AND ' . $this->buildCondition($this->getColumnAliased($column, $table), $operator, $value);
        if(isset($this->joins[$table])){
            $this->joins[$table] . $str;
        }else{
            foreach($this->joins as $alias => $join){
                if(strpos($join, 'JOIN ' . $table)){
                    $this->joins[$alias] . str_replace($table . '.', $alias . '.', $str);
                    return $this;
                }
            }
        }
        
        return $this;
    }
    
    public function endUse()
    {
        $this->alias = $this->table_alias;
    }
    
    
    
    protected $groups = [];
    
    /**
     * 
     * @param array $column
     * @return $this
     */
    public function setGroup($column)
    {
        $this->groups[] = $this->getColumnAliased($column);
        return $this;
    }
    

    /**
     * @param $expression
     * @return $this
     */
    public function setHaving($expression)
    {
        $this->havings[] = $expression;
        return $this;
    }
    
    protected $orders = [];
    
    /**
     * @param $column
     * @param string $order
     * @return $this
     */
    public function setFirstSort($column, $order = Mysql::ASC)
    {
        $column = $this->getColumnAliased($column);
        if(count($this->orders)>0){
            unset($this->orders[$column]);
            $this->orders = array_merge([$column => $column . ' ' . $order], $this->orders);
        }else{
            $this->setOrderBy($column, $order);
        }
        return $this;

    }


    /**
     * @param $column
     * @param string $order
     * @return $this
     */
    public function setOrderBy($column, $order = Mysql::ASC)
    {
        $column = $this->getColumnAliased($column);
        $this->orders[$column] = $column . ' ' . $order;
        
        return $this;

    }
    
    /**
     * 
     * @param string $column
     * @param array $values
     * @return $this
     */
    public function setOrderByField($column, $values = [], $order = Mysql::ASC)
    {
        $column = $this->getColumnAliased($column);
        $sequence = "'" . implode("','", $values) . "'";
        $this->orders[$column] = 'FIELD(' . $column . ', ' . $sequence . ') ' . $order;
        
        return $this;
    }

    /**
     * @param int $row_count
     * @param int $offset
     * @return $this
     */
    public function setLimit($row_count = 1, $offset = 0)
    {
        $this->limit[0] = ($offset == 0)? 'LIMIT ' . $row_count : 'LIMIT ' . $offset . ', ' . $row_count;
        $this->offset['limit'] = $row_count;
        $this->offset['offset'] = $offset;
        
        return $this;

    }
    
    /**
     * @return array
     */
    public function getOffset()
    {
        return $this->offset;
    }
    

}
