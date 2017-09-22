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

namespace Catrineta\framework;

use \Catrineta\register\CatExceptions;
use \Catrineta\register\Configurator;
use \Catrineta\register\Informant;
use \Catrineta\register\Monitor;
use \Catrineta\routing\Routing;
use \Apps\after\ViewInserter; 

/**
 * Description of Boot
 *
 * @author Luís Pinto / luis.nestesitio@gmail.com
 * Created @Jun 11, 2017
 */
class Boot 
{
    
    public static function run($startime)
    {
        $page = new \Catrineta\framework\Boot($startime);

        /**
         * routing
         */
        $page->router('web');
        /**
         * store requests
         */
        $page->post();
        /**
         * start session
         */
        $page->session();
        /**
         * filter the request
         */
        $page->filter();
        /**
         * launch controller
         */
        $page->boot();
        echo Informant::outputDev();
        /**
         * process other classes after controller
         */
        $page->inserter();
        /**
         * output html
         */
        echo $page->display();
        /**
         * output debug
         */
        echo Informant::outputDev();
    }

    /**
     * 
     * @param int $startime
     */
    function __construct($startime) {
        
        Monitor::setMemoryInitial($startime);
        new Configurator();
        Configurator::setConfigs();
    }

    /**
     * Routing
     */
    public function router($file)
    {
        try {
            $exec = Routing::start();
            require_once (CATRINETA_DIR . 'routing' . DS . 'functions.php');
            require_once (CATRINETA_DIR . 'url' . DS . 'functions.php');
            //processing request
            $exec->processRequest();
            //collect and compare routes
            require_once (CONFIG_DIR . 'routes' . DS . $file . '.php');
            //iteration with routes to define the route to be triggered
            $exec->defineRoute();
        } catch (CatExceptions $ex) {
            $ex->output();
        }
        
    }
    
    /**
     * process and store post requests
     */
    public function post(){
        
    }
    
    /**
     * start and renew session vars
     */
    public function session(){
        
    }
    
    /**
     * Boot filters before the controller
     * @param array $filters
     */
    public function filter(){
        
    }


    private $controller = '';

    /**
     * boot controller class and his method
     */
    public function boot()
    {
        try {
            $class = Routing::getController();
            $this->controller = new $class();
            //boot method
            $action = Routing::getAction();
            $this->controller->$action();
        } catch (CatExceptions $ex) {
            $ex->output();
        }
    }

    /**
     * integrate other processes than controller in template
     */
    public function inserter(){
        $after = new ViewInserter($this->controller);
        $after->boot();
        $after->register();
    }
    
    /**
     * output rendered template
     */
    public function display(){
        return $this->controller->dispatch();
    }


}
