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

namespace Catrineta\orm;

use \Catrineta\register\Monitor;

/**
 * Description of Model
 *
 * @author Luís Pinto / luis.nestesitio@gmail.com
 * Created @Sep 8, 2017
 */
class Model
{

    protected $columns = [];

    function __construct()
    {
        self::setModel();
    }
    
    /**
     * 
     * @param string $column
     * @param mixed $value
     */
    function setColumnValue($column, $value)
    {
        $this->columns[$column] = $value;
    } 

    /**
     * 
     * @param string $column
     * @param string $value
     */
    public function setColumnDate($column, $value)
    {
        $this->columns[$column] = \Catrineta\tools\DateTools::convertToSqlDate($value);
    }
    
    /**
     * 
     * @param string $column
     * @return mixed
     */
    function getColumnValue($column)
    {
        if(isset($this->columns[$column])){
            return $this->columns[$column];
        }else{
            Monitor::add(Monitor::DATA, (empty($column))? 'Empty column' :'Invalid column ' . $column);
            return null;
        }
    }
    
    /**
     * @return array
     */
    public function getColumnValues()
    {
        return $this->columns;
    }
    
    /**
     * @param Model $parent_model
     */
    public function merge(Model $parent_model)
    {
        $this->columns = $parent_model->getColumnValues();
    }
    

}
