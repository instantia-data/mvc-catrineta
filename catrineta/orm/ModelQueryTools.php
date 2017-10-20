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

use \Catrineta\orm\query\QueryWrite;
use \Catrineta\orm\ModelTools;
/**
 *
 * @author Luis Pinto <luis.nestesitio@gmail.com>
 */
trait ModelQueryTools
{
    
    /**
     * 
     * @return QueryWrite
     */
    protected function setQuery($columns)
    {
        $query = new QueryWrite($this);
        foreach ($columns as $column=>$value){
            $query->setValue($column, $value);
        }
        return $query;
    }
    
    /**
     * unset merged columns
     * @param type $columns
     * @param type $fields
     * @return type
     */
    protected function unsetMerged($columns, $fields)
    {
        foreach (array_keys($columns) as $column){
            if(!in_array(ModelTools::getColumnName($column), $fields)){
                unset($columns[$column]);
            }
        }
        return $columns;
    }
    
}
