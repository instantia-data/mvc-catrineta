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

namespace Catrineta\console\crud;

use \Catrineta\console\crud\CrudTools;

/**
 * Description of ModelCrud
 *
 * @author Luís Pinto / luis.nestesitio@gmail.com
 * Created @Sep 15, 2017
 */
class ModelCrud
{

    protected $table;
    
    protected $classname;
    
    protected $file;
    
    protected $template;
    
    /**
     *
     * @var \Catrineta\tools\ClassInfo
     */
    protected $info;

    function __construct($table, $classname, $info = false)
    {
        $this->table = $table;
        $this->classname = $classname;
        
        //some info about model class useful for crud form and crud query
        if($info != null){
            $this->info = CrudTools::getClassInfo('\\Model\\models\\' . $classname);
        }
        
    }
    
    protected $columns = [];
    
    protected $col_names = [];
    
    public function setColumns($columns)
    {
        
        foreach($columns as $col){
            $this->col_names[] = $col['Field'];
            $this->columns[$col['Field']] = $col;
        }
        
        return $this->col_names;
    }
    
    protected $constrains = [];
    
    public function setConstrains($constrains)
    {
        
        foreach ($constrains as $constrain){
            $this->constrains[$constrain['COLUMN_NAME']] = $constrain;
        }
    }
    
    
    protected $string = '';
    
    /**
     * Create Class file
     * @param string $class The namespace class
     */
    public function createFile($template, $file, $class, $migration)
    {
        $this->template = $template;
        $this->file = $file;
        
        $writearr = ['class'=>$this->classname, 'created'=>date('Y-m-d H:i'), 
            'updated'=>'Updated @' . date('Y-m-d H:i') . ' with columns ' . implode(", ", $this->col_names)];
        
        /*
         * ['removes'=>$removes, 'added'=>$new_columns, 'resume'=>$str]
         * or
         * ['new']
         */
        if(is_file($this->file)){
            $info = CrudTools::getClassInfo($class);
            $writearr['created'] = $info->getClassComment('Created @');
            $writearr['updated'] = implode("\n * ", $info->getLines('Updated @'));
            if (isset($migration['resume'])) {
                $writearr['updated'] .= "\n * Updated @" . date('Y-m-d H:i') . $migration['resume'];
            }
            unlink($this->file);
        }
        $this->string = CrudTools::copyFile($this->template, $this->file, $writearr);

    }

}
