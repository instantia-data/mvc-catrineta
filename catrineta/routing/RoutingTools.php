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

use \Catrineta\register\CatExceptions;

/**
 * Description of RoutingTools
 *
 * @author Luís Pinto / luis.nestesitio@gmail.com
 * Created @Jul 22, 2017
 */
class RoutingTools {

    
    /**
     * 
     * @param string $namespace A valid namespace
     * @param tstring $classname
     * @return string Class name with namespace
     * @throws CatExceptions
     */
    public static function isClass($namespace, $classname)
    {
        $namespace = self::testFolderAtNamespace($namespace);
        
        if(empty($classname)){
            throw new CatExceptions('Class name is empty',
                    CatExceptions::CODE_ROUTE);
        }
        
        $class = $namespace . '\\' . $classname;
        /*
         * 
         */
        if (!class_exists($class)) {
            throw new CatExceptions('(RoutingTools) Class "' . $class . '" is not valid',
                    CatExceptions::CODE_ROUTE);
        }
        
        return $class;
    }
    
    public static function isMethod($class, $method)
    {
        $hasFunction = (int) method_exists($class, $method);
        if ($hasFunction == 0) {
            throw new CatExceptions('(RoutingTools) Method "' . $method . '" is not valid in "' . $class . '"',
                    CatExceptions::CODE_ROUTE);
        }
        
        return $method;
    }
    
    /**
     * Test namespace in apps folder
     * @param string $namespace A normal namespace
     * @return string A namespace confirmed
     * @throws CatExceptions
     */
    public static function testFolderAtNamespace($namespace){
        $folder = str_replace(
                ['\\', 'Apps', 'Tasks'], 
                ['/', 'apps', 'apps/tasks'], 
                $namespace);

        if (!is_dir(ROOT . $folder)) {

            throw new CatExceptions('(RoutingTools) Folder "' . $folder . '" does not exists, there is no namespace', CatExceptions::CODE_ROUTE);
        }
        return $namespace;
    }
    
    /**
     * 
     * @param  \stdClass $request
     * @return Route
     * @throws CatExceptions
     */
    public static function chooseRoute($request)
    {
        $routes = RoutesCollection::get();
        foreach ($routes as $route) {
            if (self::compare($request, $route) == true) {
                return $route;
            }
        }
        throw new CatExceptions('There is no route for ' . $request->sequence, CatExceptions::CODE_ROUTE);
    }
    
    /**
     * Compare stdClass request with:
     * ["querystring"]=> array(1) { [0]=> string(0) "" } 
     * ["parts"]=> array(5) { 
     * [0]=> object (4) { ["key"]=> int(0) ["content"]=> string(0) "" ["type"]=> string(6) "string" ["frame"]=> string(0) "" } 
     * [1]=> object(stdClass)#9 (4) { ["key"]=> int(1) ["content"]=> string(5) "admin" ["type"]=> string(6) "string" ["frame"]=> string(5) "admin" } 
     * [2]=> object(stdClass)#10 (4) { ["key"]=> int(2) ["content"]=> string(4) "user" ["type"]=> string(6) "string" ["frame"]=> string(4) "user" } 
     * [3]=> object(stdClass)#11 (4) { ["key"]=> int(3) ["content"]=> string(4) "edit" ["type"]=> string(6) "string" ["frame"]=> string(4) "edit" } 
     * [4]=> object(stdClass)#12 (4) { ["key"]=> int(4) ["content"]=> string(2) "98" ["type"]=> string(7) "numeric" ["frame"]=> string(7) "numeric" } } 
     * ["sequence"]=> string(24) "/admin/user/edit/numeric" } 
     * and *****************
     * Catrineta\routing\Route $route with:
     * ["uri"]=> string(23) "/admin/user/edit/{id:d}" 
     * ["name"]=> string(0) "" 
     * ["filters"]=> array(1) { [1]=> string(9) "AdminAuth" } 
     * ["sequence"]=> string(24) "/admin/user/edit/numeric" 
     * ["vars"]=> array(4) { [1]=> int(0) [2]=> int(0) [3]=> int(0) [4]=> string(2) "id" } 
     * ["requestMethod"]=> string(3) "GET" 
     * ["action"]=> string(15) "Admin/User@edit" 
     * ["index"]=> string(21) "_uroute_5991e17e925f9"
     * @param \stdClass $request
     * @param \Catrineta\routing\Route $route
     * @return boolean
     */
    private static function compare($request, $route)
    {
        if ($route->sequence == $request->sequence) {
            return true;
        }
        
        $parts = explode('/', $route->sequence);
        if(count($parts) == count($request->parts)){
            foreach($parts as $key=>$part){
                if(self::isValidPart($request->parts[$key], $part) == false){
                    return false;
                }
            }
            return true;
        }
        
        return false;
    }
    
    /**
     * 
     * @param stdClass $part_request
     * @param string $part_route
     * @return boolean
     */
    private static function isValidPart($part_request, $part_route)
    {
        //["sequence"]=> string(24) "/admin/user/edit/numeric" 
        if($part_request->type == 'string' && $part_request->content == $part_route){
            return true;
        }
        if($part_request->type == 'numeric' && 'numeric' == $part_route){
            return true;
        }
        if($part_request->type == 'string' && 'variable' == $part_route){
            return true;
        }
        return false;
    }

    /**
     * Check if route is valid for the request uri
     * 
     * @param string $method
     * @param string $action
     * @param array $filters
     * @return boolean
     * @throws CatExceptions
     */
    public function isValid($method, $action, $filters){
        //compare two strings
        $result = $this->parseAgainstRequest(Routing::getRequest());
        if($result != false){
            //check if request (GET or POST) is valid
            if($method != Routing::getRequestMethod()){
                throw new CatExceptions('Wrong method "' . $method . '" '
                        . 'for the route "' . $this->uri . '", method should be "' . Routing::getRequestMethod() .'"',
                        CatExceptions::CODE_ROUTE);
            }
            //set the filterage for this route
            Routing::setStrainers($filters);
            //get controller and action
            $this->processAction($action);
            return true;
        }
        return false;
        
    }

    
    /**
     * 
     * @param stdClass $request The request uri
     * @return boolean
     */
    private function parseAgainstRequest(\stdClass $request){
        /**
         * Request is object(stdClass)#4 (2) { 
         * ["main"]=> array(4) { 
         * [0]=> object(stdClass)#5 (3) { 
         * ["key"]=> int(0) ["content"]=> string(1) "/" ["type"]=> string(6) "string" } 
         * [1]=> object(stdClass)#6 (3) { 
         * ["key"]=> int(1) ["content"]=> string(4) "news" ["type"]=> string(6) "string" } 
         * [2]=> object(stdClass)#7 (3) { 
         * ["key"]=> int(2) ["content"]=> string(2) "32" ["type"]=> string(7) "numeric" } 
         * [3]=> object(stdClass)#8 (3) { 
         * ["key"]=> int(3) ["content"]=> string(9) "visti.htm" ["type"]=> string(9) "canonical" } } 
         * ["querystring"]=> array(1) { [0]=> string(0) "" } } 
         */
        $parts = explode('/', $this->uri);
        
        if(count($parts) != count($request->main)){
            return false;
        }
        echo '<hr />'.$this->uri . '<br />';
        foreach($parts as $key=>$part){
            echo $key . '->' . $part . '<br />';
            if(!isset($request->main[$key])){
                return false;
            }
            if ($key > 0) {
                $result = UrlParser::partIsVar($part);
                if ($result->type != $request->main[$key]->type) {
                    return false;
                }
                
                if (isset($result->folder) && $result->folder != $request->main[$key]->content) {
                    return false;
                }
            }
        }
        return true;
    }
    
    /**
     * 
     * @param string $namespace A valid namespace
     * @param tstring $classname
     * @return string Class name with namespace
     * @throws CatExceptions
     */
    public static function isTask($namespace, $classname)
    {
        $namespace = self::testFolderAtNamespace($namespace);
        
        if(empty($classname)){
            return false;
        }
        
        $class = $namespace . '\\' . $classname;
        /*
         * 
         */
        if (!class_exists($class)) {
            return false;
        }
        
        return $class;
    }

}
