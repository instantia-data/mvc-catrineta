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
use \Catrineta\routing\RoutingTools;
use \Catrineta\register\Registry;
use \Catrineta\register\Request;
use \Catrineta\register\Monitor;
use \Catrineta\url\UrlRegister;
use \Catrineta\url\UrlParser;

/**
 * Description of Route
 *
 * @author Luís Pinto / luis.nestesitio@gmail.com
 * Created @Jun 16, 2017
 */
class Routing extends \Catrineta\routing\RequestVars
{

    /**
     * 
     * @param type $file Name of route file (web|app|console)
     * 
     * @return \Catrineta\routing\Routing
     */
    public static function start()
    {
        $route = new Routing();

        return $route;
    }

    /**
     * 
     */
    function __construct()
    {
        //Defines the request method
        $this->setRequest();
        //just initialization
        new RoutesCollection();
    }

    private static $folder;

    /**
     * The controller defined by route
     * @var Controller
     */
    private static $controller;
    private static $action;

    /**
     * Classes to be triggered before controller mainly to execute filters as session validation, 
     * defined by group of routes
     * @var type 
     */
    private static $strainers = [];
    private static $url;

    /**
     * The request object we can compare with routes
     * @var object(stdClass) 
     */
    private static $request = null;

    /**
     * 
     */
    private function setRequest()
    {
        //Defines the request method
        parent::defineRequestMethod();
        //See if request is ajax or normal
        parent::isXmlHttpRequest();
        //parse request and convert to object
        self::$url = UrlRegister::getUrlRequest();
        Request::setUrl(self::$url);
        Monitor::add(Monitor::ROUTE, 'Url is ' . self::$url);
        //register GET on Request
        Request::setHttpGet(UrlRegister::getGets());
    }

    /**
     * @return object(stdClass)
     */
    public static function getRequest()
    {
        return self::$request;
    }

    /**
     * Parse the request to later comparison with routes,
     * this define a static object
     */
    public function processRequest()
    {
        self::$request = UrlParser::parseRequest(UrlRegister::getMainPart());
        Monitor::add(Monitor::ROUTE, 'Request is ' . print_r(self::$request, 1));
    }

    /**
     * Search the route to define controller and filters
     */
    public function defineRoute()
    {
        //Get Catrineta\routing\Route from collection of routes
        $route = RoutingTools::chooseRoute(self::$request);
        Monitor::add(Monitor::ROUTE, 'Route is ' . $route->index . ' with uri ' . $route->uri);
        //associate var and route content
        Registry::defineVars($route->vars, self::$request->parts);
        //process the atribute $route->action ("Admin/User@edit")
        $route->processAction();
        //define variables from $route->vars to Registry
        $route->hasGetVariables(self::$request);
    }
    

    /**
     * 
     * @param string $uri
     * @param string $action
     * @return \Catrineta\routing\Route
     */
    public static function get($uri, $action)
    {
        return RoutesCollection::add(self::REQUEST_GET, $uri, $action);
    }

    /**
     * 
     * @param string $uri
     * @param string $action
     * @return \Catrineta\routing\Route
     */
    public static function post($uri, $action)
    {
        return RoutesCollection::add(self::REQUEST_POST, $uri, $action);
    }

    /**
     * 
     * @param string $name The first option -t for machine.php
     * @param string $task The Task class to be fired
     * @return \Catrineta\routing\Task
     */
    public static function task($name, $task)
    {
        return RoutesCollection::addTask($name, $task);
    }

    /**
     * 
     * @param array $attributes
     * @param type $routes
     * @return null
     */
    public static function group(array $attributes, $routes)
    {
        return RoutesCollection::group($attributes, $routes);
    }

    /**
     * 
     * @param string $folder
     */
    public static function setFolder($folder)
    {
        self::$folder = $folder;
    }

    /**
     * 
     * @return string
     */
    public static function getFolder()
    {
        return self::$folder;
    }

    /**
     * 
     * @return string
     */
    public static function getNamespace()
    {
        return '\Apps\\' . self::$folder . '\\';
    }

    /**
     * Define controller
     * 
     * @param string $controller
     */
    public static function setController($controller)
    {
        self::$controller = RoutingTools::isClass(self::getNamespace() . 'control', $controller);
    }

    /**
     * 
     * @return string
     * @throws CatExceptions
     */
    public static function getController()
    {
        if(null == self::$controller){
            throw new CatExceptions('Controller is empty', CatExceptions::CODE_ROUTE);
        }
        return self::$controller;
    }

    /**
     * Define controller method
     * 
     * @param string $action
     */
    public static function setAction($action)
    {
        self::$action = RoutingTools::isMethod(self::$controller, $action);
    }

    /**
     * 
     * @return string
     * @throws CatExceptions
     */
    public static function getAction()
    {
        if(null == self::$action){
            throw new CatExceptions('Action is empty', CatExceptions::CODE_ROUTE);
        }
        return self::$action;
    }

    /**
     * Registering the filters to boot before the controller
     * @param array $filters
     */
    public static function setStrainers($filters)
    {
        self::$strainers = $filters;
    }

    /**
     * 
     * @return array
     */
    public static function getStrainers()
    {
        return self::$strainers;
    }

}
