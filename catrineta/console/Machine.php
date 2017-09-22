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

namespace Catrineta\console;

use \Catrineta\routing\RoutesCollection;
use \Catrineta\register\Configurator;
use \Catrineta\register\Monitor;
use \Catrineta\routing\Routing;
use \Catrineta\routing\Task;


/**
 * Description of Machine
 * Class to use in php console
 * with options getopt
 * ("t:a:n:m:");
 *
 * @author Luís Pinto / luis.nestesitio@gmail.com
 * Created @Aug 6, 2017
 */
class Machine extends \Catrineta\console\Console
{

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
     * Start routing
     */
    public function router($file)
    {
        Routing::start();
        require_once (CATRINETA_DIR . 'routing' . DS . 'functions.php');
        require_once (CONFIG_DIR . 'routes' . DS . $file . '.php');
        
    }

    /**
     * 
     * 
     * @param string $options arguments
     */
    public function execute($options)
    {
        if(empty($options) || isset($options[self::OPT_H]) || isset($options[self::OPT_HELP])){
            $this->getMachineOptions();
            $this->getTasksAvailable();
        }
        
        foreach ([self::OPT_T, self::OPT_TASK] as $t) {
            if (isset($options[$t])) {
                $task = $options[$t];
                $tasks = RoutesCollection::getTasks();
                if (!isset($tasks[$task])) {
                    echo $task . " is not valid as task option \n";
                    $this->getTasksAvailable();
                    return false;
                }
                unset($options[$t]);
                $this->bootTask($tasks[$task], $options);
            }
        }
        
    }
    
    private function getMachineOptions()
    {
        echo "options:\n";
        foreach (self::$options as $char => $name){
            echo " -" . $char . ", --" . $name . "\n";
        }
    }
    
    private function bootTask(Task $route, $options)
    {
        if($route->isValid()){
            $class = $route->class;
            $task = $class::boot();
            
            foreach ([self::OPT_N, self::OPT_NAME] as $o) {
                if (isset($options[$o])) {
                    $task->setName($options[$o]);
                }
            }
            
            foreach ([self::OPT_A, self::OPT_APP] as $o) {
                if (isset($options[$o])) {
                    $task->setApp($options[$o]);
                }
            }
            
            foreach ([self::OPT_M, self::OPT_MODEL] as $o) {
                if (isset($options[$o])) {
                    $task->setModel($options[$o]);
                }
            }
            
            foreach ([self::OPT_O, self::OPT_OPTION] as $o) {
                if (isset($options[$o])) {
                    $task->setOption($options[$o]);
                }
            }
            
            return true;
        }
        
        echo "Class " . $class . " is no valid for task " . $route->name . "\n";
    }

    private function getTasksAvailable()
    {
        echo "Tasks available:\n";
        $tasks = RoutesCollection::getTasks();
        foreach($tasks as $task){
            echo " -" . self::OPT_T . " " . $task->name . ": " . $task->instructions() . "\n";
        }
    }


    private function manual()
    {
        
    }

}
