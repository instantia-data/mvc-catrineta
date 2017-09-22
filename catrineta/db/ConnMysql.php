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

namespace Catrineta\db;

use \Catrineta\register\Configurator;
use \PDOException;
use \PDO;

/**
 * Description of ConnMysql
 *
 * @author Luís Pinto / luis.nestesitio@gmail.com
 * Created @Aug 6, 2017
 */
class ConnMysql
{

    /**
     * @var
     */
    private static $conn;

    /* Class Constructor - Create a new database connection if one doesn't exist
     * Set to private so no-one can create a new instance via ' = new DB();' */
    /**
     * PdoMysql constructor.
     */
    private function __construct() {}

    /* Like the constructor, we make __clone private so nobody can clone the instance  */
    /**
     *
     */
    private function __clone() {}


    /**
     * Returns DB instance or create initial connection
     * @return PDO
     */
    public static function getConn()
     {
        if (!self::$conn) {
            $args = Configurator::getDbConn();
            try {
                $dsn = 'mysql:dbname=' . $args->db . ';host=' . $args->host;
                self::$conn = new PDO($dsn, $args->user, $args->password);
                //self::$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                self::$conn->setAttribute(PDO::ATTR_EMULATE_PREPARES, true);
            } catch (PDOException $err) 
            {
                if($err->getCode() == 1049){
                    echo 'Database: ' . $args->db . "\n";
                    die("Create database or correct name of database settings in config/database.php file\n");
                }
                if($err->getCode() == 1045){
                    echo 'Database: ' . $args->db . "\n";
                    die("Create user or correct user and password of database settings in config/database.php file\n");
                }
                die('ERROR: Database connection not available');
            }
        }
        

        return self::$conn;
    }
    
    /**
     * 
     * @param string $dbname
     * @return mixed
     */
    public static function createDb($dbname){
        $args = Configurator::getDbConf();
            try {
                $dsn = 'mysql:host=' . $args->host;
                self::$conn = new PDO($dsn, $args->user, $args->password);
                self::$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                self::$conn->exec("CREATE DATABASE  IF NOT EXISTS " . $dbname . " 
                    DEFAULT CHARACTER SET utf8 
                    DEFAULT COLLATE utf8_general_ci;");
                
                return $dbname;
                
            } catch (PDOException $err) 
            {
                if($err->getCode() == 1049){
                    die("Create database or correct name of database settings in config/config.xml file\n");
                }
                if($err->getCode() == 1045){
                    die("Create user or correct user and password of database settings in config/config.xml file\n");
                }
                die("DB ERROR: ". $err->getMessage());
            }
    }

}
