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

namespace Catrineta\orm\query;

use \Catrineta\register\CatExceptions;
use \Catrineta\register\Monitor;
use \Catrineta\orm\Model;
use \Catrineta\db\Sql;


/**
 * Description of QuerySelect
 *
 * @author Luís Pinto / luis.nestesitio@gmail.com
 * Created @Oct 7, 2017
 */
class QuerySelect extends \Catrineta\orm\query\Query
{
    
    /**
     *
     * @var \Catrineta\db\mysql\MysqlSelect
     */
    protected $statement = null;
    
    /**
     * 
     * @param Model $model Valid model in database
     * @param string $alias
     */
    function __construct(Model $model, $alias = null)
    {
        $this->model = $model;
        $this->statement = $this->setSelectStatement($alias);
        
    }
    
    /**
     * 
     * @param string $column
     * @param string $alias
     */
    public function setSelect($column, $alias = null)
    {
        $this->addSelect($column, $alias);
        $this->statement->setSelect($column, $alias);
        
        return $this;
    }
    
    /**
     * 
     * @param string $column
     * @param string $alias
     * @return $this
     */
    protected function addSelect($column, $alias = null)
    {
        $this->fetch[] = $this->columns[] = ($alias == null)? $column : $alias;
        return $this;
    }
    
    /**
     * 
     * @param string $merge
     */
    protected function setAllSelects($merge)
    {
        if ($merge == ALL) {
            foreach ($this->model->getFields() as $field) {
                $this->setSelect($this->model->getColumn($field));
            }
        } elseif ($merge == ONLY) {
            foreach ($this->model->getPrimaryKeys() as $field) {
                $this->setSelect($this->model->getColumn($field));
            }
        }
    }
    
    /**
     * 
     * @param string $expression SQL expression for SELECT clause
     * @param string $alias
     * @return $this
     */
    public function setCustomSelect($expression, $alias)
    {
        $this->columns[] = $alias;
        $this->statement->setCustomSelect($expression, $alias);
        $this->model->addColumn($alias);
        return $this;
    }
    
    /**
     * 
     * @param string $column The argument for the SQL function
     * @param string $function Valid SQL function
     * @param string $alias
     * @return $this
     */
    public function selectFunction($column, $function, $alias)
    {
        $this->setCustomSelect($function . '(' . $column . ')', $alias);
        
        return $this;
    }
    
    /**
     * 
     * @param bool $asterisk
     * @return $this
     */
    public function cleanSelect($asterisk = false)
    {
        $this->columns = [];
        if($asterisk == true){
            $this->columns[] = '*';
        }
        $this->statement->cleanSelect($asterisk);
        return $this;
    }

    /**
     * 
     * @param string $column
     * @param string $alias
     * @return $this
     */
    public function setDistinct($column, $alias = null)
    {
        $this->statement->setDistinct($column, $alias);
        $this->addSelect($column, $alias);
        return $this;
    }

    /**
     * @param $column
     * @param $alias
     * @return \QueryStatement
     */
    public function countDistinct($column, $alias = null)
    {
        $this->statement->countDistinct($column, $alias);
        $this->addSelect($column, $alias);
        return $this;
    }
    
    /**
     * 
     * @param string $table
     * @param string $condition INNER JOIN, LEFT JOIN or RIGHT JOIN
     * @param string $leftcol Left column of join
     * @param string $rightcol Right column of join
     * @param string $alias
     * @return $this
     */
    public function join($table, $condition, $leftcol, $rightcol, $alias = null)
    {
        if($alias == null){
            $alias = $this->statement->convertToAlias($table);
        }
        $this->statement->setJoin($table, $leftcol, $rightcol, $condition, $alias);
        $this->model->setJoin($table, $leftcol, $rightcol);
        
        return $this;
    }
    
    protected $primary_class = null;


    /**
     * @param QuerySelect $merge Other child QuerySelect class
     */
    public function startJoin(QuerySelect $merge)
    {
        //add the statement from primary class
        $this->statement = $merge->getStatement();
        //add the columns from primary class
        $this->columns = $merge->getColumns();
        //store the primary class $merge
        $this->primary_class = $merge;
    }
    
    /**
     * Give back the original class after the merge
     * @return QuerySelect
     * @throws CatExceptions
     */
    protected function completeMerge()
    {
        if(!is_object($this->primary_class)){
            throw new CatExceptions('Not primary class for ' . get_called_class(), CatExceptions::CODE_ORM);
        }
        //give back statement
        $this->primary_class->setStatement($this->statement);
        //give back columns
        $this->primary_class->setColumns($this->columns);
        $this->primary_class->mergeFetch($this->fetch);
        //give back the class
        return $this->primary_class;
    }
    
    /**
     * 
     * @param string $expression
     * @param string $alias
     * @param mixed $value
     * @return $this
     */
    public function filterByConcat($expression, $alias, $value = null)
    {
        $this->statement->setConcatCondition($expression, $alias, $value);
        return $this;
    }
    
    /**
     * 
     * @param string $column
     * @return $this
     */
    public function groupBy($column)
    {
        $this->statement->setGroup($column);
        return $this;
    }
    
    /**
     * 
     * @param string $expression
     * @return $this
     */
    public function setHaving($expression)
    {
        $this->statement->setHaving($expression);
        return $this;
    }
    
    /**
     * 
     * @param string $column
     * @param string $order (null | ASC | DESC)
     * @return $this
     */
    public function orderBy($column, $order = Sql::ASC)
    {
        $this->statement->setOrderBy($column, $order);
        return $this;
    }
    
    /**
     * Get a order by sequence of values
     * @param string $column
     * @param array $values
     * @param string $order (null | ASC | DESC)
     * @return $this
     */
    public function orderByFilter($column, $values = [], $order = Sql::ASC)
    {
        $this->statement->setOrderByField($column, $values, $order);
        return $this;
    }
    
    /**
     * Puts column for first order by
     * 
     * @param string $column
     * @param string $order
     * @return $this
     */
    public function setFirstSort($column, $order = Sql::ASC)
    {
        $this->statement->setFirstSort($column, $order);
        return $this;
    }
    
    /**
     * 
     * @param int $limit
     * @param int $offset
     * @return $this
     */
    public function limit($limit, $offset)
    {
        $this->statement->setLimit($limit, $offset);
        return $this;
    }
    
    /**
     *
     * @var int 
     */
    private $numrows = 0;
    
    /**
     * 
     * @return int
     */
    public function getNumRows()
    {
        return $this->numrows;
    }
    
     /**
     * Completes query and return a collection of model objects
     *
     * @return \Catrineta\orm\Model[]
     */
    public function find()
    {
        $pdo = $this->setPdo($this->statement);
        try {
            $rows = $pdo->select($this->statement->getStatementString());
            $this->numrows = $pdo->numrows;
            return $this->convert($rows);
        } catch (CatExceptions $ex) {
            $ex->output();
        }
    }
    
     /**
     * Completes query with limit 1.
     *
     * @return \Catrineta\orm\Model
     */
    public function findOne()
    {
        $this->statement->setLimit(1);
        $result = $this->find();
        if(!empty($result)){
            return $result[0];
        }
        return null;
    }
    
     /**
     * Completes query. If result is 0 create object
     *
     * @@return \Catrineta\orm\Model
     */
    public function findOneOrCreate()
    {
        $result = $this->findOne();
        if(!$result){
            try {
               return  $this->model->insert();
            } catch (CatExceptions $exc) {
                echo $exc->output();
            }
        }
        return $result;
    }
    
    protected function convert($rows)
    {
        $collection = [];
        foreach ($rows as $row) {
            $collection[] = $this->getRow($this->model, $row);
        }
        Monitor::add(Monitor::MODEL, 'Fetching columns: [' . implode(', ', $this->fetch) . ']');
        
        return $collection;
    }
    

}
