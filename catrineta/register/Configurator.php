<?php

/*
 * Copyright (C) 2017 Luís Pinto <luis.nestesitio@gmail.com>
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

namespace Catrineta\register;

use \stdClass;

/**
 * Description of Configurator
 *
 * @author Luís Pinto / luis.nestesitio@gmail.com
 * Created @Jul 28, 2017
 */
class Configurator
{

    /**
     * @var string
     */
    private $localhost = '127.0.1.1';

    /**
     * @var
     */
    private $host;

    /**
     * @var bool
     */
    private static $developer_mode = false;

    /**
     * Configurator constructor.
     */
    public function __construct()
    {
        $this->setMode();
    }

    private function setMode()
    {
        //Get the IPv4 address corresponding to a given Internet host name
        $this->host = gethostbyname(gethostname());
        if ($this->host == $this->localhost) {
            self::$developer_mode = true;
        }
    }

    public static function getDevMode()
    {
        return self::$developer_mode;
    }

    /**
     * 
     * @return object with data to connect database
     */
    public static function getDbConn()
    {
        $conn = new stdClass();
        $data = require_once CONFIG_DIR . 'database.php';
        if (self::$developer_mode == true) {
            $arr = $data['dev'];
        } else {
            $arr = $data['production'];
        }
        $conn = self::getConn($arr);
        return $conn;
    }

    /**
     * 
     * @param array $arr
     * @return stdClass The data to connect database
     */
    private static function getConn($arr)
    {
        $conn = new stdClass();
        $conn->host = $arr['host'];
        $conn->db = self::$config->db = $arr['db'];
        $conn->user = $arr['user'];
        $conn->password = $arr['password'];
        return $conn;
    }

    private static $config = null;

    public static function setConfigs()
    {
        $data = require_once CONFIG_DIR . 'configs.php';
        $config = new stdClass();
        $config->author = $data['author'];
        $config->project_title = $data['project']['title'];
        $config->key = $data['personal_key'];
        //langs
        $config->langs = new stdClass();
        self::setLangs($data, $config->langs);

        $config->theme_backend = $data['themes']['backend'];
        $config->theme_frontend = $data['themes']['frontend'];

        self::$config = $config;
    }
    
    private static function setLangs($data, $object)
    {
        $object->collection = $data['project']['langs'];
        foreach ($data['project']['langs'] as $key=>$lang){
            if($key == ''){
                $object->default = $lang;
            }
        }
    }
    
    /**
     * 
     * @return string
     */
    public static function getLangs()
    {
        return self::$config->langs->collection;
    }
    
    /**
     * 
     * @return string
     */
    public static function getDefaultLang()
    {
        return self::$config->langs->default;
    }

    /**
     * 
     * @return object Config object with several properties
     */
    public static function getConfig()
    {
        return self::$config;
    }

}
