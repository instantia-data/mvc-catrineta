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

use \Catrineta\routing\Route;
use \Catrineta\routing\Task;

/**
 * Description of RoutesCollection
 *
 * @author Luís Pinto / luis.nestesitio@gmail.com
 * Created @Jun 25, 2017
 */
class RoutesCollection {

    /**
     *The array of http routes
     * 
     * @var array
     */
    private static $collection = [];
    
    private static $counter = 0;
    private static $serial = [];
    private static $filters = [];
            
    function __construct() {
        self::$serial[self::$counter] = '';
    }
    
    /**
     * 
     * @return array Get the collection of routes
     */
    public static function get()
    {
        return self::$collection;
    }
    
    /**
     * Rename route with user friendly name
     * 
     * @param string $index
     * @param string $name
     */
    public static function renameIndex($index, $name){
        
        if (!array_key_exists($name, self::$collection)) {
            self::$collection[$name] = self::$collection[$index];
            unset(self::$collection[$index]);
        }
        
    }
    
    
    public static function group(array $attributes, $routes){
        self::$counter++;
        self::$serial[self::$counter] = $attributes['prefix'];
        if(isset($attributes['filter'])){
            self::$filters[self::$counter] = $attributes['filter'];
        }
        call_user_func($routes);
        unset(self::$filters[self::$counter]);
        self::$counter--;
    }
    
    /**
     * Add routes to collection and verifies if matches with request
     * Each route is a Route object defined for http protocol
     * 
     * @param string $method Routing constant
     * @param string $uri
     * @param string $action AppFolder/Controller@method
     * @return Route
     */
    public static function add($method, $uri, $action)
    {
        $uri = self::completeUri($uri);
        $route = new Route();
        $route->uri = $uri;
        $route->filters = self::$filters;
        $route->sequence = $route->sequence();
        $route->requestMethod = $method;
        $route->action = $action;
        
        //collect the routes
        $route->index = '_uroute_'. uniqid();
        self::$collection[$route->index] = $route;
        
        return $route;
    }
    
    /**
     * Compose the url with serial and the route uri string
     * 
     * @param string $uri
     * @return type
     */
    private static function completeUri($uri){
        $str = '';
        for($i = 0; $i < (self::$counter + 1); $i++){
            if($i > 0){
                $str .=  '/';
            }
            $str .=  self::$serial[$i];
        }
        if($uri== '/' && self::$counter > 0){
            $uri = '';
        }
        if(!empty($uri)){
            $str .= '/' . $uri;
        }
        $str = str_replace("//", '/', $str);
        return $str;
    }
    
    /**
     *The array of available tasks
     * 
     * @var array
     */
    private static $tasks = [];


    /**
     * 
     * @param string $name The first option char -t
     * @param string $class The class to be fired
     * @return Task
     */
    public static function addTask($name, $class)
    {
        $task = new Task();
        $task->name = $name;
        $task->task = $class;
        
        //collect the routes
        self::$tasks[$task->name] = $task;
        
        
        return $task;
    }

    /**
     * 
     * @return array Get the collection of \Catrineta\routing\Task
     */
    public static function getTasks()
    {
        return self::$tasks;
    }

}

