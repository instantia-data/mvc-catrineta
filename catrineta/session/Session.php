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

namespace Catrineta\session;



/**
 * Description of Session
 *
 * @author Luís Pinto / luis.nestesitio@gmail.com
 * Created @Nov 24, 2017
 */
class Session extends \Catrineta\session\SessionVars
{
    
    protected static $id = null;


    /**
     * Session constructor.
     */
    public function __construct()
    {
        if (session_id() === '') {
            session_start();
            self::$id = session_id();
            #session_unset ();
        }
        return $this;
    }
    
    public function refresh()
    {
        
    }

    /**
     * @var array
     */
    protected static $session = [];
    
    /**
     * @param string $key
     * @return bool|string
     */
    public static function getSessionVar($key)
    {
        if (isset($_SESSION[$key])) {
            if(!isset(self::$session[$key])){
                self::setSession($key, $_SESSION[$key]);
            }
            return $_SESSION[$key];
        }
        return false;
    }

    /* regist and refresh session vars */
    /**
     * @param string $key
     * @param string $value
     */
    public static function setSession($key, $value)
    {
        if(is_array($value)){
            foreach($value as $k => $val){
                self::$session[$key][$k] = $val;
                $_SESSION[$key][$k] = $val;
            }
        }else{
            self::$session[$key] = $value;
            $_SESSION[$key] = $value;
        }
    }

}
