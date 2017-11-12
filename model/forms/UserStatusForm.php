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

use \Model\models\UserStatus;

/**
 * Description of UserStatusForm
 *
 * @author Luís Pinto / luis.nestesitio@gmail.com
 * Created @2017-11-12 21:13
 * Updated @Updated @2017-11-12 21:13 with columns id, name *
 */
class UserStatusForm extends \Catrineta\form\Form {

    public static function initialize($declare = true){
        $form = new UserStatusForm();
        if($declare == true){
            $form->declareInputs();
        }
        return $form;
    }
    
    
    public function declareInputs(){
        $this->queue[] = UserStatus::TABLE;
        $this->models[UserStatus::TABLE] = new UserStatus();
        
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
            $input = \Catrineta\form\input\HiddenInput::create(UserStatus::FIELD_USER_STATUS_ID);
        }else{
            $input->setElementId(UserStatus::FIELD_USER_STATUS_ID); 
        }
        
        $this->setFieldInput(UserStatus::TABLE, UserStatus::FIELD_USER_STATUS_ID, $input);
        
        return $input;
    }
    
    public function setIdDefault($value) {
        $this->setDefault(UserStatus::TABLE, UserStatus::FIELD_USER_STATUS_ID, $value);
    }
    
    public function unsetIdInput() {
        $this->unsetFieldInput(UserStatus::TABLE, UserStatus::FIELD_USER_STATUS_ID);
    }
    
    /**
    * @return \lib\form\input\HiddenInput;
    */
    public function getIdInput(){
        return $this->forminputs[UserStatus::TABLE][UserStatus::FIELD_USER_STATUS_ID];
    }
    
    public function getIdValue(){
        return $this->getInputValue(UserStatus::TABLE, UserStatus::FIELD_USER_STATUS_ID);
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
            $input = \Catrineta\form\input\InputText::create(UserStatus::FIELD_USER_STATUS_NAME)->setMaxlength('100');
        }else{
            $input->setElementId(UserStatus::FIELD_USER_STATUS_NAME); 
        }
        
        $this->setFieldInput(UserStatus::TABLE, UserStatus::FIELD_USER_STATUS_NAME, $input);
        
        return $input;
    }
    
    public function setNameDefault($value) {
        $this->setDefault(UserStatus::TABLE, UserStatus::FIELD_USER_STATUS_NAME, $value);
    }
    
    public function unsetNameInput() {
        $this->unsetFieldInput(UserStatus::TABLE, UserStatus::FIELD_USER_STATUS_NAME);
    }
    
    /**
    * @return \lib\form\input\InputText;
    */
    public function getNameInput(){
        return $this->forminputs[UserStatus::TABLE][UserStatus::FIELD_USER_STATUS_NAME];
    }
    
    public function getNameValue(){
        return $this->getInputValue(UserStatus::TABLE, UserStatus::FIELD_USER_STATUS_NAME);
    }
    
    public function validateNameInput() {
        $input = $this->getNameInput();
        return $input->validate();
    }
    
    
    
    
    
    

}
