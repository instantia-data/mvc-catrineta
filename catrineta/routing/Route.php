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

use \Catrineta\routing\RoutesCollection;
use \Catrineta\register\CatExceptions;
use \Catrineta\register\Registry;
use \Catrineta\register\Monitor;
use \Catrineta\routing\Routing;
use \Catrineta\url\UrlParser;


/**
 * Description of Route
 *
 * @author Luís Pinto / luis.nestesitio@gmail.com
 * Created @Jul 14, 2017
 */
class Route {

    function __construct() { }
    
    public $uri = '/';
    
    public $name = '';
    
    public $filters = [];
    
    public $sequence = '';
    
    public $vars = [];
    
    public $requestMethod = Routing::REQUEST_GET;
    
    public $action = '';


    /**
     * Rename route with user friendly name
     * 
     * @param string $name
     */
    public function name($name){
        RoutesCollection::renameIndex($this->index, $name);
        $this->index = $name;
    }
    
    public $index = null;
    
    /**
     * Run each part of the uri
     * 
     * @return string A string to compare with request
     */
    public function sequence()
    {
        $sequence = '';
        $parts = explode('/', $this->uri);
        foreach($parts as $key=>$part){
            if ($key > 0) {
                $result = UrlParser::partIsVar($part);
                if($result->type == 'string'){
                    if(!isset($result->folder)){
                        new CatExceptions('Misshapen route for uri:' . $this->uri . ', error for ' . $part, 
                        CatExceptions::CODE_ROUTE);
                    }else{
                        $sequence .= '/' . $result->folder;
                    }
                    $this->vars[$key] = 0;
                }else{
                    $sequence .= '/' . $result->type;
                    $this->vars[$key] = $result->varname;
                }
            }
        }
        
        return $sequence;
    }
    

    /**
     * Test and tell Routing what controller and method to controller
     * processing the attribute $this->action
     * @param string $action
     * @throws CatExceptions
     */
    public function processAction(){
        /**
         * object(Catrineta\routing\Route)#20 (8) { 
         * ["uri"]=> string(23) "/admin/user/edit/{id:d}" 
         * ["name"]=> string(0) "" 
         * ["filters"]=> array(1) { [1]=> string(9) "AdminAuth" } 
         * ["sequence"]=> string(24) "/admin/user/edit/numeric" 
         * ["vars"]=> array(4) { [1]=> int(0) [2]=> int(0) [3]=> int(0) [4]=> string(2) "id" } 
         * ["requestMethod"]=> string(3) "GET" 
         * ["action"]=> string(15) "Admin/User@edit" 
         * ["index"]=> string(21) "_uroute_5991d022252b0" } 
         */
        if (!strpos($this->action, '@') || !strpos($this->action, '/')) {
            throw new CatExceptions('Wrong configuration in action for the route "' . $this->uri . '"',
                    CatExceptions::CODE_ROUTE);
        }
        Monitor::add(Monitor::ROUTE, 'Route have action ' . $this->action);
        list($c, $method) = explode('@', $this->action);
        list($folder, $control) = explode('/', $c);
        Routing::setFolder($folder);
        Monitor::add(Monitor::ROUTE, 'Route have folder ' . $folder);
        Routing::setController($control);
        Monitor::add(Monitor::ROUTE, 'Route have controller ' . $control);
        Routing::setAction($method);
        Monitor::add(Monitor::ROUTE, 'Route have method ' . $method);
    }
    
    /**
     * Search for GET variables in the route
     * @param type $request
     */
    public function hasGetVariables($request)
    {
        /**
         * $this->vars
         * ["vars"]=> array(4) { [1]=> int(0) [2]=> int(0) [3]=> int(0) [4]=> string(2) "id" } 
         * compare to $request->parts as
         *   [4]=> object(stdClass)#12 (4) 
         * { ["key"]=> int(4) ["content"]=> string(2) "98" 
         * ["type"]=> string(7) "numeric" ["frame"]=> string(7) "numeric" 
         * }
         * 
         */
        foreach ($request->parts as $key=>$part){
            if(isset($this->vars[$key]) && $this->vars[$key] != 0){
                Registry::setVar($this->vars[$key], $part->content);
            }
        }
    }
    
    
    
    

}
