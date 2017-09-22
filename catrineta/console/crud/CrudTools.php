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

namespace Catrineta\console\crud;

use \Catrineta\tools\ClassInfo;

/**
 * Description of CrudTools
 *
 * @author Luís Pinto / luis.nestesitio@gmail.com
 * Created @Sep 2, 2017
 */
class CrudTools
{

    /**
     * @param string $source Source file
     * @param string $dst Destiny file
     * @param array $arr Content to be replaced
     * 
     * @return string The content of the file
     */
    public static function copyFile($source, $dst, $arr =[])
    {
        copy($source, $dst);
        $string = file_get_contents($dst);
        $string = str_replace('%$dateCreated%', $arr['created'], $string);
        $string = str_replace('%$dateUpdated%', $arr['updated'], $string);
        $string = str_replace('%$className%', $arr['class'], $string);
        file_put_contents($dst, $string);
        
        return $string;
    }

        
    /**
     * 
     * @param string $class Class name with namespace
     * @return \Catrineta\tools\ClassInfo
     */
    public static function getClassInfo($class)
    {
        return new ClassInfo($class);
    }
    
    /**
     * @param String $table
     * @param String $field
     * @param String $maintable
     * @return string
     */
    public static function writeFieldConstantName($table, $field, $maintable = null)
    {
        $str = ($maintable == null || $table == $maintable)? '' : StringTools::getStringAfterLastChar($table, '_') . '_';
        return 'FIELD_' . strtoupper($table) . '_' . strtoupper($field);
    }

}
