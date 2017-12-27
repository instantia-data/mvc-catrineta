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

namespace Catrineta\register;

/**
 * Description of Request
 *
 * @author Luís Pinto / luis.nestesitio@gmail.com
 * Created @Nov 26, 2017
 */
class Request
{

    private static $url;

    public static function setUrl($url)
    {
        self::$url = $url;
    }
    
    /**
     *
     * @var HTTP GET variables 
     */
    private static $http_get = [];
    
    /**
     * Register HTTP GET variables
     * @param array $arr
     */
    public static function setHttpGet($arr)
    {
        self::$http_get = $arr;
    }
    
    /**
     * @param $key
     * @return bool|mixed
     */
    public static function getHttpGet($key = null)
    {
        if(null == $key){
            return self::$http_get;
        }
        return (isset(self::$http_get [$key])) ? self::$http_get [$key] : false;
    }
    
    /**
     *
     * @var HTTP POST variables 
     */
    private static $http_post = [];
    
    /**
     * Regiser HTTP POST variables
     * @param array $arr
     */
    public function setHttpPost($arr)
    {
        self::$http_post = $arr;
    }
    
    /**
     * Regiser HTTP POST variable
     * 
     * @param string $key
     * @param mixed $value
     */
    public function setPost($key, $value)
    {
        self::$http_post[$key] = $value;
    }
    
    /**
     * @param $key
     * @return bool|mixed
     */
    public static function getHttpPost($key = null)
    {
        if(null == $key){
            return self::$http_post;
        }
        return (isset(self::$http_post [$key])) ? self::$http_post [$key] : false;
    }
    
    /**
     *
     * @var int 
     */
    public static $id = 0;
    
    /**
     *
     * @var string 
     */
    public static $canonical = '';
    
    /**
     *
     * @var string 
     */
    public static $lang = '';

}
