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

/**
 * Description of MysqlWrite
 *
 * @author Luís Pinto / luis.nestesitio@gmail.com
 * Created @Oct 13, 2017
 */
class MysqlWrite extends \Catrineta\db\mysql\MysqlSelect
{
    /**
     * 
     * INSERT INTO prp_incentive_scale
(prp_incentive_id, scale, units, clients, points)
SELECT 
i.units, i.clients, i.points
FROM prp_incentive i
LEFT JOIN prp_incentive s 
ON i.prp_campaign_id = s.prp_campaign_id 
AND i.company_target_id = s.company_target_id
AND i.product_target_id = s.product_target_id
GROUP BY s.prp_campaign_id, s.company_target_id, s.product_target_id
     */

    public function getInsertString()
    {
        $statement = [];
        
        if (count($this->columns) == 0) {
            throw new CatExceptions('No columns defined for INSERT query', CatExceptions::CODE_SQL);
        }else{
            $statement['columns'] = '(' . implode(', ', $this->columns) . ')';
        }
        
        
        if (count($this->selects) > 0 && null != $this->select_table) {
            $statement['select_expr'] = 'SELECT ' . implode(', ', $this->selects) . ' FROM ' . $this->select_table;
            if (count($this->joins) > 0) {
                $statement['joins'] = implode(' ', $this->joins);
            }
            if (count($this->wheres) > 0) {
                $statement['wheres'] = 'WHERE ' . implode(' AND ', $this->wheres);
            }
            if (count($this->groups) > 0) {
                $statement['group_condition'] = 'GROUP BY ' . implode(', ', $this->groups);
            }
        } elseif (count($this->values) > 0) {
            $statement['values'] = 'VALUES (' . implode(', ', $this->values) . ')';
        }

        return 'INSERT INTO ' . $this->main_table . implode(' ', $statement);
    }
    
    public function getUpdateString()
    {
        $statement = [];

        if (count($this->updates) == 0) {
            throw new CatExceptions('No updates defined for UPDATE query', CatExceptions::CODE_SQL);
        }
        if (count($this->joins) > 0) {
            $statement['joins'] = implode(' ', $this->joins);
        }
        $statement['updates'] = 'SET ' . implode(', ', $this->updates);
        if (count($this->wheres) > 0) {
            $statement['wheres'] = 'WHERE ' . implode(' AND ', $this->wheres);
        }
        #echo implode(' ', $statement) . '<hr />';
        return 'UPDATE ' . $this->main_table . ' ' . implode(' ', $statement);
    }

    public function getDeleteString()
    {
        $statement = [];
        if (count($this->joins) > 0) {
            $statement['joins'] = implode(' ', $this->joins);
        }
        if (count($this->wheres) > 0) {
            $statement['wheres'] = 'WHERE ' . implode(' AND ', $this->wheres);
        }
        return 'DELETE FROM ' . $this->main_table . ' WHERE ' . implode(' ', $statement);
    }
    
    protected $select_table = null;
    
    /**
     *
     * @var array
     */
    protected $updates = [];
    
    /**
     *
     * @var array
     */
    protected $columns = [];
    
    /**
     *
     * @var array
     */
    protected $values = [];
    
    public function setValue($column, $value)
    {
        $col = str_replace('.', '_', $column);
        $this->params[$col] = $value;
        //to UPDATE
        $this->updates[] = $column . '= :' . $col;
        
        //to INSERT
        $this->columns[] = $column;
        $this->values[] = ':' . $col;
        
    }
    


}
