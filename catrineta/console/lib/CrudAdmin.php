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

use \Catrineta\console\crud\ParseLoop;
use \Catrineta\console\crud\CrudTools;
use \Catrineta\db\mysql\DbSchemaTools;
use \Catrineta\register\Configurator;
use \Catrineta\console\Console;
use \Catrineta\orm\ModelTools;

/**
 * Description of CrudApp
 *
 * @author Luís Pinto / luis.nestesitio@gmail.com
 * Created @Oct 28, 2017
 */
class CrudAdmin
{

    private $folder;
    
    private $app;

    private $name;
    

    function __construct($folder, $app, $name)
    {
        $this->folder= $folder;
        $this->name = $name;
        $this->app = $app;
    }
    
    private $columns = [];
    
    private $constraints = [];
    
    /**
     * 
     * @return string The table to build model query
     */
    public function getTable()
    {
        //demand, test and return table
        $table = Console::ask('Wich table you want to admin?');
        $tables = DbSchemaTools::getTables();
        if(!in_array($table, $tables)){
            echo "There is no table " . $table . " in database \n";
            print_r($tables);
            return $this->getTable();
        }
        //get the array of columns
        $this->columns = CrudTools::collectColumns($table);
        //get the array of constraints
        $this->constraints = DbSchemaTools::getConstraints(Configurator::getConfig()->db, $table);
        
        return $table;
    }
    
    /**
     * Build file with Query class
     * @param array $arr
     * @return void
     */
    public function writeQuery($arr= [])
    {
        
        $template = RESOURCES_DIR . 'scaffold' . DS . 'classes' . DS . 'app_model.tpl';
        $file = $this->folder . 'model' . DS . $this->name . 'UtilQueries.php';
        
        if (!is_file($file)) {
            $string = $this->copy($template, $file, $arr, 'UtilQueries');
            $parse = new ParseLoop($string);
            $this->loopJoins($parse);

            file_put_contents($file, $parse->parseWhile());
        }
    }
    
    /**
     * Build file with Form class
     * @param array $arr
     * @return void
     */
    public function writeForm($arr = [])
    {
        
        $template = RESOURCES_DIR . 'scaffold' . DS . 'classes' . DS . 'app_form.tpl';
        $file = $this->folder . 'model' . DS . $this->name . 'UtilForm.php';
        if(!is_file($file)){
            $this->copy($template, $file, $arr, 'UtilForm');
        }
        
        
        
    }
    
    /**
     * Build file with Controller class
     * @param array $arr
     * @return void
     */
    public function writeController($arr = [])
    {
        $template = RESOURCES_DIR . 'scaffold' . DS . 'classes' . DS . 'app_controller.tpl';
        $file = $this->folder . 'control' . DS . $this->name . 'Controller.php';
        
        if(!is_file($file)){
            $this->copy($template, $file, $arr, 'Controller');
        }
        
    }
    
    /**
     * 
     * @param string $table
     * @param array $arr
     */
    public function writeView($table, $arr = [])
    {
        $crud = new \Catrineta\console\lib\CrudViewAdmin($this->folder, $this->app, $this->name);
        $crud->writeMainView($arr);
        $pks = ModelTools::getPrimary($table);
        $crud->writeTable($this->columns, $pks);
        $columns = ModelTools::getColumns($table);
        $crud->writeForm($columns);
        $crud->writeFilter($columns);
    }
    
    
    public function writeLang()
    {
        foreach(Configurator::getConfig()->langs as $lang){
            $this->writeOneLang($lang);
        }
    }
    
    private function writeOneLang($lang)
    {
        $template = RESOURCES_DIR . 'scaffold' . DS . 'lang.tpl';
        $file = $this->folder . 'lang' . DS . $lang . DS . strtolower($this->name) . '.php';
        
        if (!is_file($file)) {
            $string = $this->copy($template, $file, [], 'lang');

            $parse = new ParseLoop($string);
            foreach ($this->columns as $column) {
                $parse->setData('columns', [
                    'colname' => ModelTools::getColumnName($column),
                    'translation' => ucwords(str_replace(['.', '_'], ' ', $column))
                ]);
            }

            file_put_contents($file, $parse->parseWhile());
        }
    }
    
    /**
     * 
     * @param string $template The original file
     * @param string $file The destination file
     * @param array $arr Array of content to inject in destination file
     * @param string $name Name of the file
     * @return string The file_get_content from copied file
     */
    private function copy($template, $file, $arr, $name)
    {
        return CrudTools::copyFile($template, $file, $arr);
    }
    
    private function loopJoins(ParseLoop $parse)
    {
        foreach($this->constraints as $constrain){
            $table = $constrain['REFERENCED_TABLE_NAME'];
            $columns = DbSchemaTools::getColumns($table);
            $selects = [];
            foreach($columns as $column){
                $selects[] = '->select' . ModelTools::buildModelName($column['Field']) . '()';
            }
            $parse->setData('joins', [
                'tableJoin'=>ModelTools::buildModelName($table),
                'selects'=> implode('', $selects)
            ]);
        }
    }

}
