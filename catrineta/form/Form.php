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

use \Catrineta\form\Input;

/**
 * Description of Form
 *
 * @author Luís Pinto / luis.nestesitio@gmail.com
 * Created @Sep 22, 2017
 */
class Form
{
    
    /**
     *
     * @var array The models to be merged
     */
    protected $models = [];

    function __construct()
    {
        
    }
    
    /**
     * @var array
     */
    protected $forminputs = [];
    
    /**
     * @param string $field
     * @param \Catrineta\form\Input $input
     * @return \Catrineta\form\Input
     */
    public function setFieldInput($field, Input $input)
    {
        $this->forminputs[$field] = $input;
        return $this->forminputs[$field];
    }
    
    /**
     * @param $field
     * @return $this
     */
    public function unsetFieldInput($field)
    {
        unset($this->forminputs[$field]);
        return $this;
    }
    
    /**
     * @param $field
     * @param $value
     * @return mixed
     */
    public function setFieldValue($field, $value)
    {
        return $this->forminputs[$field]->setValue($value);
    }
    
    public function renderFormInputs()
    {
        $inputs = [];
        foreach ($this->forminputs as $input){
            $inputs[] = $input->parseInput();
        }
        
        return $inputs;
    }
    
    
    public function getInputs()
    {
        return $this->forminputs;
    }
    
    public static function renderInput($input)
    {
        echo $input;
    }

}
