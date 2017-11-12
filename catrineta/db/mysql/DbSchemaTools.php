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

use \Catrineta\db\mysql\ConnMysql;


/**
 * Description of DbSchemaTools
 *
 * @author Luís Pinto / luis.nestesitio@gmail.com
 * Created @Sep 4, 2017
 */
class DbSchemaTools
{

    /**
     * 
     * @return array
     */
    public static function getTables()
    {
        $pdo = ConnMysql::getConn();
        
        $query = "SHOW TABLES";
        $sth = $pdo->prepare($query);
        $sth->execute();
        $tables = $sth->fetchAll();
        $arr = [];
        foreach ($tables as $row){
            $arr[] = $row[0];
        }
        return $arr;
        
    }
    
    /**
     * Get columns from table
     * 
     * @param string $table
     * @return array Returns an array containing all of the result set rows
     */
    public static function getColumns($table)
    {
        $pdo = ConnMysql::getConn();
        
        $sth = $pdo->prepare("SHOW FULL COLUMNS FROM " . $table);
        $sth->execute();
        /**
         * [x] => Array
         * [Field] => name
            [Type] => varchar | int | etc.
            [Collation] => utf8_general_ci
            [Null] => YES
            [Key] => PRIM ! MUL |
            [Default] => 
            [Extra] => 
            [Privileges] => select,insert,update,references
            [Comment] => 
         */
        $columns = $sth->fetchAll(\PDO::FETCH_ASSOC);
        foreach($columns as $k=>$field){
            $columns[$k]['Kind'] = $field['Type'];
            $columns[$k]['Size'] = 0;
            $type = $field['Type'];
            $columns[$k]['Key'] = $field['Key'];
            /*
             * Determine string for index Kind that resume Type literaly
             * (varchar, int, datetime)
             * Determine Size field
             */
            $limit = strstr($type, '(');
            if($limit != false){
                $columns[$k]['Kind'] = str_replace($limit, '', $field['Type']);
                $columns[$k]['Size'] = str_replace(['(',')'], '', $limit);
            } elseif ($field['Type'] == 'date' 
                    || $field['Type'] == 'time' 
                    || $field['Type'] == 'datetime' 
                    || $field['Type'] == 'year') {
                $columns[$k]['Kind'] = 'datetime';
            }
            
        }
        return $columns;
    }
    
    /**
     * 
     * @param string $db
     * @param string $table
     * @return array
     */
    public static function getConstraints($db, $table = null)
    {
        $constraints = [];
        $pdo = ConnMysql::getConn();
        
        $query = "SELECT
            i.TABLE_NAME, i.CONSTRAINT_TYPE, 
            k.REFERENCED_TABLE_NAME, k.REFERENCED_COLUMN_NAME, k.COLUMN_NAME, k.CONSTRAINT_NAME
            FROM information_schema.TABLE_CONSTRAINTS i
            LEFT JOIN information_schema.KEY_COLUMN_USAGE k ON i.CONSTRAINT_NAME = k.CONSTRAINT_NAME
            WHERE i.CONSTRAINT_TYPE = 'FOREIGN KEY'
            AND i.TABLE_SCHEMA = '$db' ";
        if(null != $table){
            $query .= " AND (i.TABLE_NAME = '$table' OR k.REFERENCED_TABLE_NAME = '$table') ";
        }
        $query .= " GROUP BY i.TABLE_NAME, k.COLUMN_NAME";
        
        $sth = $pdo->prepare($query);
        $sth->execute();
        $results = $sth->fetchAll();
        $i = 0;
        foreach ($results as $row) {
            $constraints[$i]['TABLE_NAME'] = $table;
            $constraints[$i]['CONSTRAINED'] = $row[0];
            $constraints[$i]['CONSTRAINT_TYPE'] = $row[1];
            $constraints[$i]['REFERENCED_TABLE_NAME'] = ($row[0] == $table)?$row[2] : $row[0];
            $constraints[$i]['REFERENCED_COLUMN_NAME'] = ($row[0] == $table)? $row[3] : $row[4];
            $constraints[$i]['COLUMN_NAME'] = ($row[0] == $table)? $row[4] : $row[3];
            $constraints[$i]['CONSTRAINT_NAME'] = $row[5];
            $i++;
        }

        return $constraints;
        
    }
    
    public static function getIndexes($db, $table)
    {
        $pdo = ConnMysql::getConn();
        $query = "SHOW INDEX FROM $table FROM $db ";
        $indexes = [];
        $sth = $pdo->prepare($query);
        $sth->execute();
        $results = $sth->fetchAll();
        foreach ($results as $row) {
            if ($row['Key_name'] != 'PRIMARY') {
                $indexes[] = [
                    'Key_name' => $row['Key_name'],
                    'Column_name' => $row['Column_name']
                ];
            }
        }
        
        return $indexes;
    }


    public static function getOrderConstraints($db)
    {
        $query = "SELECT 
        TABLE_NAME, GROUP_CONCAT(CONSTRAINT_NAME) AS constraints, COUNT(*) AS Rows
        FROM TABLE_CONSTRAINTS 
        WHERE TABLE_SCHEMA = '$db' AND CONSTRAINT_TYPE LIKE 'FOREIGN_KEY' GROUP BY TABLE_NAME ORDER BY Rows DESC"; 
        
        $constraints = [];
        
        $sth = $pdo->prepare($query);
        $sth->execute();
        $results = $sth->fetchAll();
        foreach ($results as $row) {
            
        }
        return $constraints;
    }

}
