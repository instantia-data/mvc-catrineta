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

namespace Tasks\catrineta\lib;

use \Catrineta\console\crud\ParseLoop;
use \Catrineta\orm\ModelTools;

/**
 * Description of CrudQuery
 *
 * @author Luís Pinto / luis.nestesitio@gmail.com
 * Created @Sep 22, 2017
 */
class CrudQuery extends  \Catrineta\console\crud\ModelCrud
{

    public function parseLoops()
    {
        $parse = new ParseLoop($this->string);
        foreach($this->columns as $field){
            
            $this->makeMethods($parse, $field);
        }
        
        foreach ($this->constrains as $join){
            
            $this->makeJoins($parse, $join);
        }
        
        file_put_contents($this->file, $parse->parseWhile());
    }
    
    private function makeMethods(ParseLoop $parse, $field)
    {
        $parse->setData('columns', [
            'method' => ModelTools::buildModelName($field['Field']),
            'table' => $this->classname . '::TABLE',
            'field' => $this->classname . '::' . ModelTools::getFieldConstant($this->table, $field['Field']),
            
        ]);
    }
    
    /**
     *   
     * Array $join: 
     * [TABLE_NAME], [CONSTRAINT_TYPE] => FOREIGN KEY, [REFERENCED_TABLE_NAME]
     * [REFERENCED_COLUMN_NAME], [COLUMN_NAME] 
     * 
     * @param ParseLoop $parse
     * @param array $join
     */
    private function makeJoins(ParseLoop $parse, $join)
    {
        $model = ModelTools::buildModelName($join['REFERENCED_TABLE_NAME']);
        $parse->setData('joins', [
            'tablejoin' => $model,
            'table' => $model . '::TABLE',
            'leftcol' => $this->classname . '::' . ModelTools::getFieldConstant($this->table, $join['COLUMN_NAME']),
            'rightcol' => $model . '::' . ModelTools::getFieldConstant($join['REFERENCED_TABLE_NAME'], $join['REFERENCED_COLUMN_NAME'])
            
        ]);
    }

}
