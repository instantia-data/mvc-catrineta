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

use \Catrineta\register\Configurator;

/**
 * Description of Task
 *
 * @author Luís Pinto / luis.nestesitio@gmail.com
 * Created @Sep 1, 2017
 */
class Task
{

    public $name = '';
    
    public function setName($name)
    {
        $this->name = $name;
    }
    
    protected function issetName()
    {
        if(empty($this->name)){
            echo "add option -n to give your app a name\n";
            return false;
        }
        return true;
    }
    
    public $app = '';
    
    public function setApp($app)
    {
        $this->app = $app;
    }
    
    protected function issetApp()
    {
        if(empty($this->app)){
            echo "add option -a to give your app a folder app\n";
            return false;
        }
        return true;
    }
    
    public $model = '';
    
    public function setModel($model)
    {
        $this->model = $model;
    }
    
    public $option = '';
    
    public function setOption($option)
    {
        $this->option = $option;
    }
    
    protected $folder;
    
    /**
     * Get or create the folders for /apps
     * @param string $name
     * @return $this
     */
    protected function setAppFolder($name)
    {
        $this->folder = APPS_DIR . $name;
        if (!is_dir($this->folder)) {
            if (mkdir($this->folder) == true) {
                echo "Generate backend app " . $this->app . " ... \n";
                echo " \n";
            } else {
                echo "Generated app " . $this->app . " failed ... \n";
            }
        }else{
            echo "Generated app " . $this->app . " already created ... \n";
        }
        
        $subfolders = ['control', 'model', 'view', 'assets', 'lang'];
        foreach ($subfolders as $fold) {
            if (!is_dir($this->folder . DS . $fold)) {
                 if (mkdir($this->folder . DS . $fold) == true) {
                     echo "folder " . $this->app . DS . $fold . ", ";
                 }
            }
        }
        
        foreach(Configurator::getConfig()->langs as $lang){
            if (!is_dir($this->folder . DS . 'lang' . DS . $lang)) {
                mkdir($this->folder . DS . 'lang' . DS . $lang);
            }
        }
        
        
        echo " \n";
        return $this->folder . DS;
    }
}
