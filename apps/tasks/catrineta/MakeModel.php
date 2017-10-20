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

use \Catrineta\db\mysql\DbSchemaTools;
use \Catrineta\register\Configurator;
use \Tasks\catrineta\lib\CrudMigrate;
use \Tasks\catrineta\lib\CrudModel;
use \Tasks\catrineta\lib\CrudQuery;
use \Tasks\catrineta\lib\CrudForm;
use \Catrineta\orm\ModelTools;

/**
 * Description of MakeModel
 * @info Build the basic model classes reading the database
 * 1. Query database and get Constrains
 * 2. Loop tables and for each verify if has file otherwise create new file
 * 3. Get template source 
 * 4. Replace string
 *
 * @author Luís Pinto / luis.nestesitio@gmail.com
 * Created @Sep 1, 2017
 */
class MakeModel extends \Catrineta\console\Task
{
    
    public static function boot()
    {
        $task = new MakeModel();
        $task->loopTables();
        
        echo "end task \n";
        return $task;
    }

    
    private $tables = [];

    function __construct()
    {
        $this->tables = DbSchemaTools::getTables();
        echo "Starting task model\n";
    }
    
    
    public function loopTables()
    {
        foreach ($this->tables as $table){
            $class = ModelTools::buildModelName($table);
            
            echo $table . ' is ' . $class . "\n";
            //get the array of columns
            $columns = DbSchemaTools::getColumns($table);
            //get the rray of constrains
            $constrains = DbSchemaTools::getConstrains(Configurator::getConfig()->db, $table);
            //build model class file
            $m  = $this->buildModel($table, $class, $columns, $constrains);
            //weather is new or updated
            $migration = $m->getMigrate();
            //build migration file
            $this->buildMigration($table, $class, $columns, $migration);
            //build form class file
            $this->buildForm($table, $class, $columns, $constrains, $migration);
            //build query class file
            $this->buildQuery($table, $class, $columns, $constrains, $migration);
            
            
            echo "***********\n";
        }
    }
    
    private function buildModel($table, $class, $columns, $constrains)
    {
        echo "Building model \n";
        $crud  = new CrudModel($table, $class);
        $columnnames = $crud->setColumns($columns);
        echo "Columns: " . implode(', ', $columnnames) . "\n";
        $crud->setConstrains($constrains);
        $crud->modelFile(ModelTools::getModelNamespace($table));
        $crud->crudInfos();
        $crud->parseLoops();
        
        return $crud;
    }
    
    private function buildMigration($table, $class, $columns, $migration)
    {
        echo "Building migration \n";
        $crud = new CrudMigrate($table, $class);

        if ($crud->setMigrates($migration)) {
            echo "Generating migration " . $crud->migrateFile() . "\n";
            $crud->setColumns($columns);
            $crud->parseLoops();
        }
    }
    
    private function buildForm($table, $class, $columns, $constrains, $migration)
    {
        echo "Form  ";
        $crud = new CrudForm($table, $class, true);
        echo "building ...\n ";
        
        $crud->setColumns($columns);
        $crud->setConstrains($constrains);
        
        $template = RESOURCES_DIR. 'scaffold' . DS . 'model' . DS . 'form.tpl';
        $file = MODEL_DIR . 'forms' . DS . $class . 'Form.php';
        $crud->createFile($template, $file, '\\Model\\forms\\' . $class . 'Form', $migration);
        $crud->parseLoops();
        echo "is done \n";
    }
    
    private function buildQuery($table, $class, $columns, $constrains, $migration)
    {
        echo "Query ";
        $crud = new CrudQuery($table, $class, true);
        echo "building ... ";

        $crud->setColumns($columns);
        $crud->setConstrains($constrains);

        $template = RESOURCES_DIR. 'scaffold' . DS . 'model' . DS . 'query.tpl';
        $file = MODEL_DIR . 'querys' . DS . $class . 'Query.php';
        $crud->createFile($template, $file, '\\Model\\querys\\' . $class . 'Query', $migration);
        $crud->parseLoops();
        echo "is done \n";
        
    }

    private function cleanFolders()
    {
        foreach (['models', 'querys', 'forms'] as $folder){
            array_map('unlink', glob(MODEL_DIR . $folder . DS . '*'));
        }
    }

}
