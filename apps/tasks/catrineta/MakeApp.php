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

namespace Tasks\catrineta;

use \Catrineta\console\Console;
use \Catrineta\orm\ModelTools;

/**
 * Description of MakeApp
 *
 * @author Luís Pinto / luis.nestesitio@gmail.com
 * Created @Sep 1, 2017
 */
class MakeApp extends \Catrineta\console\Task
{

    public static function boot()
    {
        $task = new MakeApp();
        
        return $task;
    }

    function __construct(){}
    
    public function execute()
    {
        $this->test();
        $this->folder = $this->setAppFolder($this->app);
        
        $type = $this->getType();
        if($type == 'app'){
            $this->buildApp();
        }
        if($type == 'admin'){
            $this->buildAdmin();
        }
        if($type == 'cms'){
            $this->buildCms();
        }
        
        echo "end task \n";
    }
    
    
    private function test()
    {
        //test arguments
        $this->issetName();
        $this->issetApp();
        if(empty($this->name) || empty($this->app)){
            die();
        }

    }
    
    /**
     *
     * @var array of types of controller we want to build
     */
    private $types = ['app', 'admin', 'cms'];
    
    /**
     * 
     * @return string The type of controller we want to build 
     */
    private function getType()
    {
        $type = Console::ask('Wich type of controller you want to create? ' . implode(', ', $this->types));
        if(in_array($type, $this->types)){
            return $type;
        }
        echo "Type is not valid, choose valid type";
        return $this->getType();
    }
    
    private function buildApp()
    {
        
    }
    
    /**
     * We build controller type admin and useful files
     */
    private function buildAdmin()
    {
        $crud = new \Catrineta\console\lib\CrudAdmin($this->folder, $this->app, $this->name);
        $table = $crud->getTable();
        $this->model = ModelTools::buildModelName($table);
        $arr = [
            'className'=>$this->name, 'created'=>date('Y-m-d H:i'), 'updated'=>date('Y-m-d H:i'), 
            'nameApp' => $this->app, 'modelName'=> $this->model
                ];
        $crud->writeQuery($arr);
        $crud->writeForm($arr);
        $crud->writeController($arr);
        $crud->writeView($table);
        $crud->writeLang();
    }
    
    private function buildCms()
    {
        
    }
    

    

}
