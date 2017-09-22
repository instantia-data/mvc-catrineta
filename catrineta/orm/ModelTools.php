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
 * Description of ModelTools
 *
 * @author Luís Pinto / luis.nestesitio@gmail.com
 * Created @Sep 8, 2017
 */
class ModelTools
{

    /**
     * @param $name
     * @return mixed
     */
    public static function buildModelName($name)
    {
        $name = str_replace('_', ' ', $name);
        $name = ucwords($name);
        return str_replace(' ', '', $name);
    }
    
    /**
     * @param $table
     * @return mixed
     */
    public static function getModelQuery($table)
    {
        $class = '\\Model\\querys\\' . self::buildModelName($table) . 'Query';
        return $class::create();
    }

    /**
     * @param $table
     * @return mixed
     */
    public static function getModelForm($table)
    {
        $class = '\\Model\\forms\\' . self::buildModelName($table) . 'Form';
        return new $class();
    }

    /**
     * @param $table
     * @return mixed
     */
    public static function getModel($table)
    {
        $class = '\\Model\\models\\' . self::buildModelName($table);
        return new $class();
    }
    
    /**
     * @param $table
     * @return mixed
     */
    public static function getModelNamespace($table)
    {
        return '\\Model\\models\\' . self::buildModelName($table);
    }
    
    /**
     * 
     * @param string $table
     * @param string $field
     * @return string
     */
    public static function getFieldConstant($table, $field, $maintable = null)
    {
        $str = ($maintable == null || $table == $maintable)? $table . '_' : StringTools::getStringAfterLastChar($table, '_') . '_';
        return 'FIELD_' . strtoupper($str) . strtoupper($field);
    }
    
    /**
     * 
     * @param array $list
     * @param array $columns
     * @return boolean | array
     */
    public static function isModelUpdated($list, $columns)
    {
        $removes = [];
        foreach ($list as $col){
            if(!isset($columns[$col])){
                $removes[] = $col;
            }
        }
        $added = $new_columns = [];
        foreach($columns as $key=>$column){
            if(!in_array($key, $list)){
                $new_columns[$key] = $column;
                $added[] = $key;
            }
        }
        
        if(empty($removes) && empty($added)){
            return false;
        }else{
            $str = '';
            if(!empty($removes)){
                $str .= 'removed fields: ' . implode(', ', $removes) . '; ';
            }
            if(!empty($added)){
                $str .= 'added fields: ' . implode(', ',  $added) . '; ';
            }
            return ['removes'=>$removes, 'added'=>$new_columns, 'resume'=>$str];
        }
    }

}