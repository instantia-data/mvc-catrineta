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

use \Catrineta\register\CatExceptions;
use \Catrineta\db\mysql\Mysql;

/**
 * Description of MysqlStatement
 *
 * @author Luís Pinto / luis.nestesitio@gmail.com
 * Created @Oct 6, 2017
 */
class MysqlStatement 
{

    
    protected $selects = [];
    
    protected $table = null;
    
    protected $table_alias = null;
    
    protected $alias = null;
    
    function __construct($table, $alias = null)
    {
        $this->table = $table;
        
        $this->table_alias = (null == $alias) ? $this->table : $alias;
        $this->alias = $this->table_alias;
    }
    
    protected $params = [];
    
    /**
     * 
     * @return array The parameters to bind values in PDO
     */
    public function getParams()
    {
        return $this->params;
    }
    
    protected $wheres = [];
    
    /**
     * 
     * @param string $column
     * @param string $operator
     * @param mixed $value
     * @param string $wildcard '%'
     * @return $this
     */
    protected function buildCondition($column, $operator, $value, $wildcard = null)
    {
        $col = str_replace('.', '_', $column);
        $param = ($wildcard == '%') ? '%' . $value . '%' : $value;
        $this->params[$col] = $param;
        return $column . $operator . ':' . $col;
        
    }
    
    /**
     * @param $column
     * @param array $values
     * @param string $clause
     * @return $this
     */
    public function buildArrayCondition($column, $values = [], $clause = Mysql::IN)
    {
        $col = str_replace('.', '_', $column);
        $i = 0;
        $params = [];
        foreach($values as $value){
            $this->params[$col . $i] = $value;
            $params[] = $col . $i++;
        }
        if($clause == Mysql::BETWEEN){
            return $column . $clause . "'" . implode("' AND '", $params) . "'";
        }else{
            return $column . $clause . "('" . implode("', '", $params) . "')";
        }
    }
    

    
    public function setCondition($column, $values, $operator = Mysql::EQUAL, $wildcard= null)
    {
        $column = $this->getColumnAliased($column);
        if($operator == Mysql::BETWEEN){
            if($values['max'] == null && $values['min'] == null){
                throw new CatExceptions('Null range of values min and max for column ' . $column, CatExceptions::CODE_SQL);
            }elseif($values['max'] == null){
                $this->wheres[] = $this->buildCondition($column, Mysql::GREATER_EQUAL, $values['min']);
            }elseif($values['min'] == null){
                $this->wheres[] = $this->buildCondition($column, Mysql::LESS_EQUAL, $values['max']);
            }else{
                $this->wheres[] = $this->buildArrayCondition($column, $values, Mysql::BETWEEN);
            }
        }elseif(is_array($values)){
            if($operator == Mysql::EQUAL){
                $operator = Mysql::IN;
            }
            $this->wheres[] = $this->buildArrayCondition($column, $values, $operator);
        }else{
            $this->wheres[] = $this->buildCondition($column, $operator, $values, $wildcard);
        }

        return $this;
    }
    
    /**
     * @param $column
     * @param $null
     * @return $this
     */
    public function whereIsNullOrNot($column, $null = null)
    {
        $column = $this->getColumnAliased($column);
        $condition = $column;
        $condition .= ($null == null)? Mysql::ISNULL : $null;
        $this->wheres[] = $condition;
        return $this;
    }
    
     /**
     * @param string $column
     * @param string $operator
     * @param string $expression Raw mysql expression
     * @return $this
     */
    public function setExpressionCondition($column, $operator, $expression = '')
    {
        $column = $this->getColumnAliased($column);
        $this->wheres[] = $column . $operator . $expression ;
        return $this;
    }

    /**
     * @param $expression Raw mysql expression
     * @return $this
     */
    public function where($expression)
    {
        $this->wheres[] = $expression ;
        return $this;
    }

    /**
     * @param $array
     * @return $this
     */
    public function whereOr($array)
    {
        $parts = [];
        foreach($array as $column=>$value){
            $column = $this->getColumnAliased($column);
            if(is_array($value)){
                $parts[] = $this->buildArrayCondition($column, $value, Mysql::IN);
            }else{
                $parts[] = $this->buildCondition($column, Mysql::EQUAL, $value);
            }
        }
        $this->wheres[] = "(" . implode(" OR ", $parts) . ")";
        return $this;
    }

    /**
     * @return mixed
     */
    public function getLastWhere()
    {
        return end($this->wheres);
    }

    /**
     * Pop the element off the end of array
     * @return mixed The last value of array
     */
    protected function getAndPopLastWhere()
    {
        return array_pop($this->wheres);
    }

    /**
     * @param $expression
     * @param string $operator
     */
    public function joinWhere($expression, $operator = Mysql::LOGICAL_OR)
    {
        $condition = $this->getAndPopLastWhere();
        $this->wheres[] = '(' . $condition . " $operator " . $expression . ')';

    }
    
    protected function getColumnAliased($column, $table = null)
    {
        if($table == null){
            $table = strstr($column, '.', true);
        }
        if($table != false){
            $field = str_replace($table . '.', '', $column);
            if($table == $this->table){
                return $this->table_alias . '.' . $field;
            }else{
                foreach($this->joins as $alias => $join){
                    if(strpos($join, 'JOIN ' . $table) || 
                            $alias == $table){
                        return $alias . '.' . $field;
                    }
                }
            }
        }
    }

}
