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


/**
 * Description of MysqlSelect
 *
 * @author Luís Pinto / luis.nestesitio@gmail.com
 * Created @Oct 6, 2017
 */
class MysqlSelect extends \Catrineta\db\mysql\MysqlStatement
{

    /**
     *
     * @var \Catrineta\db\mysql\MysqlSelect 
     */
    protected $statement = null;

    /**
     * @return string Mysql statement
     */
    public function getStatementString()
    {
        $statement = [];
        
        if(count($this->selects) > 0){
            $statement['select_expr'] = implode(', ', $this->selects);
        }
 
        $statement['table'] = ' FROM ' . $this->main_table;
        if ($this->getFirstAlias() != $this->main_table) {
            $statement['table'] = ' AS ' . $this->getFirstAlias();
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
        
        return 'SELECT SQL_CALC_FOUND_ROWS ' . implode(' ', $statement);
    }
    
    protected $fetchs_assoc = [];
    
    
    /**
     * 
     * @param string $column
     * @param string $alias
     * @return $this
     */
    public function setSelect($column, $alias = null)
    {
        $str = $this->getColumnAliased($column, $this->alias);
        if(null != $alias){
            $str .= ' AS ' . $alias;
        }
        $this->fetchs_assoc = (null != $alias)? $alias : $str;
        $this->selects[] = $str;
        return $this;
    }
    
    /**
     * 
     * @param string $expression
     * @param string $alias
     * @return $this
     */
    public function setCustomSelect($expression, $alias)
    {
        $this->selects[] = $expression . ' AS '. $alias;
        $this->fetchs_assoc = $alias;
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
    public function setDistinct($column, $alias)
    {
        $column = $this->getColumnAliased($column);
        $this->selects[] = 'DISTINCT ' . $column . ' AS '. $alias;
        $this->fetchs_assoc = $alias;

    }

    /**
     * @param $column
     * @param $alias
     */
    public function countDistinct($column, $alias)
    {
        $column = $this->getColumnAliased($column);
        $this->selects[] = 'COUNT(DISTINCT ' . $column . ') AS '. $alias;
        $this->fetchs_assoc = $alias;
    }
    
    /**
     * Clean the select clause
     * 
     * @param bool $asterisk
     */
    public function cleanSelect($asterisk = false)
    {
        $this->selects = [];
        $this->fetchs_assoc = [];
        if($asterisk == true){
            $this->selects[] = '*';
        }
 
    }

    /**
     * 
     * @param string $expression
     * @param string $alias
     * @param mixed $value
     * @return $this
     */
    public function setConcatCondition($expression, $alias, $value = null)
    {
        $this->wheres[] = 'CONCAT(' . $expression . ') LIKE "' . $value . '"';
        $this->selects[] = 'CONCAT(' . $expression . ') AS '. $alias;
        $this->fetch_assoc[] = $alias;
        return $this;
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
        $this->putJoinOnStack($table, $alias);
        
        $str = $join . ' ' . $table . ' ';
        if(null != $alias){
            $str .= 'AS ' . $alias . ' ';
        }
        $str .= 'ON ' . $this->getColumnAliased($left, $this->getPreviousAlias()) . '=' . str_replace($table, $this->alias, $right);       
        
        $this->joins[$this->alias] = $str;
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
    
    /**
     * 
     * @return array
     */
    public function getJoinsKeys()
    {
        return array_keys($this->joins);
    }
    
    public function endUse()
    {
        $this->stack_of_joins = array_pop($this->stack_of_joins);
        $this->alias = $this->getAlias();
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
    
    protected $havings = [];

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
     * Get a order by sequence of values
     * @param string $column
     * @param array $values
     * @param string $order (null | ASC | DESC)
     * @return $this
     */
    public function setOrderByField($column, $values = [], $order = Sql::ASC)
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
        $this->limit[0] = ($offset == 0)? $row_count : $offset . ', ' . $row_count;
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
