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

namespace Catrineta\console\lib;

use \Catrineta\console\crud\CrudTools;
use \Catrineta\console\crud\ParseLoop;
use \Catrineta\orm\ModelTools;

/**
 * Description of CrudViewAdmin
 *
 * @author Luís Pinto / luis.nestesitio@gmail.com
 * Created @Nov 1, 2017
 */
class CrudViewAdmin
{

    private $folder;
    
    private $subfolder;
    
    private $app;
    
    private $name;

    function __construct($folder, $app, $name)
    {
        $this->folder= $folder;
        $this->app = strtolower($app);
        $this->name = strtolower($name);
        $this->subfolder = $this->folder . 'view' . DS . $this->name ;
        if (!is_dir($this->subfolder)) {
            mkdir($this->subfolder);
        }
    }
    
    public function writeMainView()
    {
        $template = RESOURCES_DIR . 'scaffold' . DS . 'views' . DS . 'admin' . DS . 'index.tpl';
        $file = $this->folder . 'view' . DS . $this->name . '.html';
        if(!is_file($file)){
            return CrudTools::copyFile($template, $file, [
                'viewName'=> $this->name
            ]);
        }
    }
    
    
    public function writeTable($columns, $pks)
    {
        $template = RESOURCES_DIR . 'scaffold' . DS . 'views' . DS . 'admin' . DS . 'table.tpl';
        $file = $this->folder . 'view' . DS . $this->name . DS . 'table.html';
        $this->copy($template, $file, $columns, $pks);
    }
    
    public function writeForm($columns)
    {
        $template = RESOURCES_DIR . 'scaffold' . DS . 'views' . DS . 'admin' . DS . 'form.tpl';
        $file = $this->folder . 'view' . DS . $this->name . DS . 'form.html';
        $this->copy($template, $file, $columns);
    }
    
    public function writeFilter($columns)
    {
        $template = RESOURCES_DIR . 'scaffold' . DS . 'views' . DS . 'admin' . DS . 'filter.tpl';
        $file = $this->folder . 'view' . DS . $this->name . DS . 'filter.html';
        $this->copy($template, $file, $columns);
    }
    
    private function copy($template, $file, $columns, $pks = [])
    {
        if(!is_file($file)){
            $string = CrudTools::copyFile($template, $file, $this->getArrReplace($pks));
            $parse = new ParseLoop($string);
            $this->loopColumns($parse, $columns);
            file_put_contents($file, $parse->parseWhile());
        } 
    }
    
    private function getArrReplace($pks = [])
    {
        return [
            'name' => $this->name, 'appurl' => $this->app,
            'nameurl' => strtolower($this->name), 'name' => strtolower($this->name), 'id' => implode('-', $pks)
        ];
    }

    private function loopColumns(ParseLoop $parse, $columns = [])
    {
        foreach($columns as $column){
            $parse->setData('columns', [
                'colname'=>$column
            ]);
        }
    }

}
