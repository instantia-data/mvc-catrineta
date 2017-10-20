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

use \Catrineta\orm\Model;

/**
 * Description of QueryWrite
 *
 * @author Luís Pinto / luis.nestesitio@gmail.com
 * Created @Oct 13, 2017
 */
class QueryWrite extends \Catrineta\orm\query\QuerySelect
{
    
    /**
     *
     * @var \Catrineta\db\mysql\MysqlWrite
     */
    protected $statement = null;

    /**
     * 
     * @param Model $model
     * @param string $alias
     */
    function __construct(Model $model, $alias = null)
    {
        parent::__construct($model, $alias);
        $this->statement = $this->setWriteStatement($alias);
    }
    
    /**
     * 
     * @param string $column
     * @param mixed $value
     * @return $this
     */
    public function setValue($column, $value)
    {
        $this->statement->setValue($column, $value);
        return $this;
    }
    
    /**
     * 
     * @return int The ID of the last inserted row or sequence value
     */
    public function insert($autoincrement = null)
    {
        
        $pdo = $this->setPdo($this->statement);
        $pdo->setStatementQuery($this->statement->getInsertString());
        $pdo->setParams($this->statement->getParams());
        return $pdo->insert($autoincrement);
        
    }
    
    
    public function update()
    {
        $pdo = $this->setPdo($this->statement);
        $pdo->setStatementQuery($this->statement->getUpdateString());
        $pdo->setParams($this->statement->getParams());
        return $pdo->update();
    }
    
    /**
     * 
     * @return bool <b>TRUE</b> on success or <b>FALSE</b> on failure.
     */
    public function delete()
    {
        $pdo = $this->setPdo($this->statement);
        $pdo->setParams($this->statement->getParams());
        return $pdo->delete();
        
    }

}
