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

namespace Catrineta\form;

use \Catrineta\orm\ModelTools;

/**
 * Description of MergeForm
 *
 * @author Luís Pinto / luis.nestesitio@gmail.com
 * Created @Dec 7, 2017
 */
class MergeForm
{

    /**
     *
     * @var array The queue for merged forms
     */
    protected $queue = [];
    
    /**
     *
     * @var array The forms to be merged 
     */
    protected $forms = [];
    
    /**
     *
     * @var array 
     */
    protected $inputs = [];
    
    /**
     *
     */
    const VIRTUALTABLE = 'no_table';
    
    function __construct()
    {
        
    }
    
    protected function merge($fk_merge = true)
    {
        
        foreach ($this->forms as $table=>$form){
            $this->inputs[$table] = $form->getInputs();
            $constraints = $this->models[$table]->getConstraints();
            foreach (array_keys($this->inputs[$table]) as $field) {
                $column = ModelTools::getColumnName($field);
                if ($fk_merge == true && isset($constraints[$column])
                         && isset($this->forms[$constraints[$column]['table']])
                        ){
                    $form->setFieldInput($field, \Catrineta\form\inputs\HiddenInput::create($field));
                }
            }
        }
    }
    
    public function render()
    {
        $view = new \stdClass();
        foreach ($this->inputs as $form){
            foreach ($form as $input){
                $name = ModelTools::mergeName($input->getName());
                $view->$name = $input->parseInput();
            }
            
        }
        
        return $view;
    }

}
