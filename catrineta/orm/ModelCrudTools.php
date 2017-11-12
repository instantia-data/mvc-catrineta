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

/**
 *
 * @author Luis Pinto <luis.nestesitio@gmail.com>
 */
trait ModelCrudTools
{
    /**
     * Used by crud to get fields added or removed from a table
     * @param array $list
     * @param array $columns
     * @return boolean | array
     */
    public static function isModelUpdated($list, $columns)
    {
        //fields to remove
        $removes = self::getRemovedColumns($columns, $list);
        //fields to add
        $added = self::getAddedColumns($columns, $list);
        
        if(empty($removes) && empty($added)){
            return false;
        }else{
            $str = '';
            if(!empty($removes)){
                $str .= 'removed fields: ' . implode(', ', $removes) . '; ';
            }
            if(!empty($added)){
                $str .= 'added fields: ' . implode(', ', array_keys($added)) . '; ';
            }
            return ['removes'=>$removes, 'added'=>$added, 'resume'=>$str];
        }
    }
    
    private static function getRemovedColumns($columns, $list)
    {
        $removes = [];
        foreach ($list as $col){
            if(!isset($columns[$col])){
                $removes[] = $col;
            }
        }
        return $removes;
    }
    
    private static function getAddedColumns($columns, $list)
    {
        $added = $new_columns = $constraints_add = [];
        foreach($columns as $key=>$column){
            if(!in_array($key, $list)){
                $added[$key] = $column;
            }
        }
        
        return $added;
    }
    
    /**
     * 
     * @param array $contraints
     * @param array $changes
     * @return array Array with constraints to remove and add
     */
    public static function hasConstraintsToChange($contraints, $changes)
    {
        $removes = [];
        foreach($changes['removes'] as $col){
            if(isset($contraints[$col])){
                $removes[] = $contraints[$col];
            }
        }
        $added = [];
        foreach (array_keys($changes['added']) as $col){
            if(isset($contraints[$col])){
                $added[] = $contraints[$col];
            }
        }
        return ['removes'=>$removes, 'added'=>$added];
    }
}
