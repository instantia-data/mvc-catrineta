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

namespace Catrineta\routing;

use \Catrineta\register\Monitor;

/**
 * Description of RequestVars
 *
 * @author Luís Pinto / luis.nestesitio@gmail.com
 * Created @Jun 23, 2017
 */
abstract class RequestVars {

    const XHTTP = 'XMLHttpRequest';
    
    const REQUEST_GET = 'GET';
    
    const REQUEST_POST = 'POST';
    
    const REQUEST_CONSOLE = 'CONSOLE';

    
    /**
     *
     * @var string
     * Defines the request method 
     */
    protected static $method = null;
    
    protected static $xmlHttpRequest = false;
    
    /**
     * Defines the request method 
     */
    protected function defineRequestMethod(){
        self::$method = filter_var(getenv('REQUEST_METHOD'));
        
        Monitor::add(Monitor::ROUTE, 'Requested method is ' . self::$method);

    }
    
    /**
     * Info about the request (POST or GET)
     * @return string
     */
    public static function getRequestMethod(){
        return self::$method;
    }

        /**
     * Define if request is Ajax
     */
    protected function isXmlHttpRequest(){
        $ajax = filter_var(getenv('HTTP_X_REQUESTED_WITH'));
        if($ajax == self::XHTTP){
            self::$xmlHttpRequest = true;
            Monitor::add(Monitor::ROUTE, 'Request is ' . self::XHTTP);
        }
        
    }

}

