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

use \Model\models\UserEvent;

/**
 * Description of UserEventForm
 *
 * @author Luís Pinto / luis.nestesitio@gmail.com
 * Created @2018-01-19 18:03
 * Updated @Updated @2018-01-19 18:03 with columns id, name *
 */
class UserEventForm extends \Catrineta\form\Form {

    /**
     * 
     * @param boolean $declare
     * @return \Model\forms\UserEventForm
     */
    public static function initialize($declare = true){
        $form = new UserEventForm();
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
        $this->models[UserEvent::TABLE] = new UserEvent();
        
        $this->setIdInput();
        $this->setNameInput();
        return $this;
    }
    
    public function validate(){
        
        $this->validateIdInput();
        $this->validateNameInput();
        
        return $this;
    }
    
    
    
    
    /**
    * Create and return the input associeted with field
    * 
    * @return \lib\form\input\HiddenInput;
    */
    public function setIdInput($input = null) {
        if($input == null){
            $input = \Catrineta\form\inputs\HiddenInput::create(UserEvent::FIELD_USER_EVENT_ID);
        }else{
            $input->setElementId(UserEvent::FIELD_USER_EVENT_ID); 
        }
        
        $this->setFieldInput(UserEvent::FIELD_USER_EVENT_ID, $input);
        
        return $input;
    }
    
    public function setIdDefault($value) {
        $this->setDefault(UserEvent::TABLE, UserEvent::FIELD_USER_EVENT_ID, $value);
    }
    
    public function unsetIdInput() {
        $this->unsetFieldInput(UserEvent::FIELD_USER_EVENT_ID);
    }
    
    /**
    * @return \lib\form\input\HiddenInput;
    */
    public function getIdInput(){
        return $this->forminputs[UserEvent::FIELD_USER_EVENT_ID];
    }
    
    public function getIdValue(){
        return $this->getInputValue(UserEvent::FIELD_USER_EVENT_ID);
    }
    
    public function validateIdInput() {
        $input = $this->getIdInput();
        return $input->validate();
    }
    
    
    
    /**
    * Create and return the input associeted with field
    * 
    * @return \lib\form\input\InputText;
    */
    public function setNameInput($input = null) {
        if($input == null){
            $input = \Catrineta\form\inputs\InputText::create(UserEvent::FIELD_USER_EVENT_NAME)->setMaxlength('100');
        }else{
            $input->setElementId(UserEvent::FIELD_USER_EVENT_NAME); 
        }
        
        $this->setFieldInput(UserEvent::FIELD_USER_EVENT_NAME, $input);
        
        return $input;
    }
    
    public function setNameDefault($value) {
        $this->setDefault(UserEvent::TABLE, UserEvent::FIELD_USER_EVENT_NAME, $value);
    }
    
    public function unsetNameInput() {
        $this->unsetFieldInput(UserEvent::FIELD_USER_EVENT_NAME);
    }
    
    /**
    * @return \lib\form\input\InputText;
    */
    public function getNameInput(){
        return $this->forminputs[UserEvent::FIELD_USER_EVENT_NAME];
    }
    
    public function getNameValue(){
        return $this->getInputValue(UserEvent::FIELD_USER_EVENT_NAME);
    }
    
    public function validateNameInput() {
        $input = $this->getNameInput();
        return $input->validate();
    }
    
    
    
    
    
    

}
