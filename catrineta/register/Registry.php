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

use \Catrineta\register\Monitor;
use \Catrineta\register\Request;

/**
 * Description of Registry
 *
 * @author Luís Pinto / luis.nestesitio@gmail.com
 * Created @Aug 8, 2017
 */
class Registry
{

            
    function __construct()
    {
        
    }
    
    private static $vars = [];
    
    /**
     * 
     * @param string $key
     * @param mixed $value
     */
    public static function setVar($key, $value)
    {
        self::$vars[$key] = $value;
        Monitor::create(Monitor::GET, 'GET variable ' . $key . '=' . $value);
    }
    
    /**
     * 
     * @param string $key
     * @return mixed
     */
    public static function get($key = null)
    {
        if(null == $key){
            return self::$vars;
        }
        return self::$vars[$key];
    }
    

    /**
     * 
     * @param array $sequence
     * @param \stdClass $request
     */
    public static function defineVars($sequence, $request)
    {
        foreach($sequence as $i =>$var){
            if(!empty($var) && isset($request[$i])){
                self::setVar($var, $request[$i]->content);
                if($var == 'id'){
                    Request::$id = $request[$i]->content;
                    Monitor::add(Monitor::ROUTE, 'Request id is ' . Request::$id);
                }
                if($var == 'canonical'){
                    Request::$canonical = $request[$i]->content;
                    Monitor::add(Monitor::ROUTE, 'Request canonical is ' . Request::$canonical);
                }
            }
        }
    }

}
