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

namespace Model\forms;

use \Model\models\%$className%;

/**
 * Description of %$className%Form
 *
 * @author Luís Pinto / luis.nestesitio@gmail.com
 * Created @%$dateCreated%
 * Updated @%$dateUpdated% *
 */
class %$className%Form extends \Catrineta\form\Form {

    /**
     * 
     * @param boolean $declare
     * @return \Model\forms\%$className%Form
     */
    public static function initialize($declare = true){
        $form = new %$className%Form();
        if($declare == true){
            $form->declareInputs();
        }
        return $form;
    }
    
    /**
     * Initialize all inputs
     * @return $this
     */
    public function declareInputs(){
        $this->models[%$className%::TABLE] = new %$className%();
        {@while ($item in columns):}
        $this->set{$item.method}Input();{@endwhile;}{@while ($item in selects):}
        $this->set{$item.method}Input();{@endwhile;}
        return $this;
    }
    
    public function validate(){
        {@while ($item in validates):}
        $this->validate{$item.method}Input();{@endwhile;}
        
        return $this;
    }
    
    
    {@while ($item in columns):}
    
    /**
    * Create and return the input associeted with field
    * 
    * @return \lib\form\input\{$item.inputMethod};
    */
    public function set{$item.method}Input($input = null) {
        if($input == null){
            $input = \Catrineta\form\inputs\{$item.inputMethod}::create({$item.field}){$item.extension};
        }else{
            $input->setElementId({$item.field}); 
        }
        
        $this->setFieldInput({$item.field}, $input);
        
        return $input;
    }
    
    public function set{$item.method}Default($value) {
        $this->setDefault({$item.table}, {$item.field}, $value);
    }
    
    public function unset{$item.method}Input() {
        $this->unsetFieldInput({$item.field});
    }
    
    /**
    * @return \lib\form\input\{$item.inputMethod};
    */
    public function get{$item.method}Input(){
        return $this->forminputs[{$item.field}];
    }
    
    public function get{$item.method}Value(){
        return $this->getInput{$item.getval}({$item.field});
    }
    
    public function validate{$item.method}Input() {
        $input = $this->get{$item.method}Input();
        return $input->validate();
    }
    
    {@endwhile;}
    
    
    {@while ($item in selects):}
    
    /**
    * Create and return the input associeted with field
    * 
    * @return \Catrineta\form\inputs\{$item.inputMethod};
    */
    public function set{$item.method}Input($input = null) {
        if($input == null){
            $input = \Catrineta\form\inputs\{$item.inputMethod}::create({$item.field})
                {$item.extension}
                ->setRequired(true)
                ->setDefault('{$item.default}');
        }else{
            $input->setElementId({$item.field}); 
        }
        
        $this->setFieldInput({$item.field}, $input);
        
        return $input;
    }
    
    public function set{$item.method}Default($value) {
        $this->setDefault({$item.table}, {$item.field}, $value);
    }
    
    public function unset{$item.method}Input() {
        $this->unsetFieldInput({$item.table}, {$item.field});
    }
    
    /**
    * @return \lib\form\input\{$item.inputMethod};
    */
    public function get{$item.method}Input(){
        return $this->forminputs[{$item.table}][{$item.field}];
    }
    
    public function get{$item.method}Value(){
        return $this->getInputValue({$item.table}, {$item.field});
    }
    
    public function validate{$item.method}Input() {
        $input = $this->get{$item.method}Input();
        return $input->validate();
    }
    
    {@endwhile;}
    

}
