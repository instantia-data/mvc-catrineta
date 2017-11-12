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

use \Model\models\UserGuard;

/**
 * Description of UserGuardForm
 *
 * @author Luís Pinto / luis.nestesitio@gmail.com
 * Created @2017-11-12 21:13
 * Updated @Updated @2017-11-12 21:13 with columns user_id, username, salt, userkey *
 */
class UserGuardForm extends \Catrineta\form\Form {

    public static function initialize($declare = true){
        $form = new UserGuardForm();
        if($declare == true){
            $form->declareInputs();
        }
        return $form;
    }
    
    
    public function declareInputs(){
        $this->queue[] = UserGuard::TABLE;
        $this->models[UserGuard::TABLE] = new UserGuard();
        
        return $this;
    }
    
    public function validate(){
        
        $this->validateUserIdInput();
        $this->validateUsernameInput();
        $this->validateSaltInput();
        $this->validateUserkeyInput();
        
        return $this;
    }
    
    
    
    
    /**
    * Create and return the input associeted with field
    * 
    * @return \lib\form\input\HiddenInput;
    */
    public function setUserIdInput($input = null) {
        if($input == null){
            $input = \Catrineta\form\input\HiddenInput::create(UserGuard::FIELD_USER_GUARD_USER_ID);
        }else{
            $input->setElementId(UserGuard::FIELD_USER_GUARD_USER_ID); 
        }
        
        $this->setFieldInput(UserGuard::TABLE, UserGuard::FIELD_USER_GUARD_USER_ID, $input);
        
        return $input;
    }
    
    public function setUserIdDefault($value) {
        $this->setDefault(UserGuard::TABLE, UserGuard::FIELD_USER_GUARD_USER_ID, $value);
    }
    
    public function unsetUserIdInput() {
        $this->unsetFieldInput(UserGuard::TABLE, UserGuard::FIELD_USER_GUARD_USER_ID);
    }
    
    /**
    * @return \lib\form\input\HiddenInput;
    */
    public function getUserIdInput(){
        return $this->forminputs[UserGuard::TABLE][UserGuard::FIELD_USER_GUARD_USER_ID];
    }
    
    public function getUserIdValue(){
        return $this->getInputValue(UserGuard::TABLE, UserGuard::FIELD_USER_GUARD_USER_ID);
    }
    
    public function validateUserIdInput() {
        $input = $this->getUserIdInput();
        return $input->validate();
    }
    
    
    
    /**
    * Create and return the input associeted with field
    * 
    * @return \lib\form\input\InputText;
    */
    public function setUsernameInput($input = null) {
        if($input == null){
            $input = \Catrineta\form\input\InputText::create(UserGuard::FIELD_USER_GUARD_USERNAME)->setMaxlength('100');
        }else{
            $input->setElementId(UserGuard::FIELD_USER_GUARD_USERNAME); 
        }
        
        $this->setFieldInput(UserGuard::TABLE, UserGuard::FIELD_USER_GUARD_USERNAME, $input);
        
        return $input;
    }
    
    public function setUsernameDefault($value) {
        $this->setDefault(UserGuard::TABLE, UserGuard::FIELD_USER_GUARD_USERNAME, $value);
    }
    
    public function unsetUsernameInput() {
        $this->unsetFieldInput(UserGuard::TABLE, UserGuard::FIELD_USER_GUARD_USERNAME);
    }
    
    /**
    * @return \lib\form\input\InputText;
    */
    public function getUsernameInput(){
        return $this->forminputs[UserGuard::TABLE][UserGuard::FIELD_USER_GUARD_USERNAME];
    }
    
    public function getUsernameValue(){
        return $this->getInputValue(UserGuard::TABLE, UserGuard::FIELD_USER_GUARD_USERNAME);
    }
    
    public function validateUsernameInput() {
        $input = $this->getUsernameInput();
        return $input->validate();
    }
    
    
    
    /**
    * Create and return the input associeted with field
    * 
    * @return \lib\form\input\InputText;
    */
    public function setSaltInput($input = null) {
        if($input == null){
            $input = \Catrineta\form\input\InputText::create(UserGuard::FIELD_USER_GUARD_SALT)->setMaxlength('128');
        }else{
            $input->setElementId(UserGuard::FIELD_USER_GUARD_SALT); 
        }
        
        $this->setFieldInput(UserGuard::TABLE, UserGuard::FIELD_USER_GUARD_SALT, $input);
        
        return $input;
    }
    
    public function setSaltDefault($value) {
        $this->setDefault(UserGuard::TABLE, UserGuard::FIELD_USER_GUARD_SALT, $value);
    }
    
    public function unsetSaltInput() {
        $this->unsetFieldInput(UserGuard::TABLE, UserGuard::FIELD_USER_GUARD_SALT);
    }
    
    /**
    * @return \lib\form\input\InputText;
    */
    public function getSaltInput(){
        return $this->forminputs[UserGuard::TABLE][UserGuard::FIELD_USER_GUARD_SALT];
    }
    
    public function getSaltValue(){
        return $this->getInputValue(UserGuard::TABLE, UserGuard::FIELD_USER_GUARD_SALT);
    }
    
    public function validateSaltInput() {
        $input = $this->getSaltInput();
        return $input->validate();
    }
    
    
    
    /**
    * Create and return the input associeted with field
    * 
    * @return \lib\form\input\InputText;
    */
    public function setUserkeyInput($input = null) {
        if($input == null){
            $input = \Catrineta\form\input\InputText::create(UserGuard::FIELD_USER_GUARD_USERKEY)->setMaxlength('128');
        }else{
            $input->setElementId(UserGuard::FIELD_USER_GUARD_USERKEY); 
        }
        
        $this->setFieldInput(UserGuard::TABLE, UserGuard::FIELD_USER_GUARD_USERKEY, $input);
        
        return $input;
    }
    
    public function setUserkeyDefault($value) {
        $this->setDefault(UserGuard::TABLE, UserGuard::FIELD_USER_GUARD_USERKEY, $value);
    }
    
    public function unsetUserkeyInput() {
        $this->unsetFieldInput(UserGuard::TABLE, UserGuard::FIELD_USER_GUARD_USERKEY);
    }
    
    /**
    * @return \lib\form\input\InputText;
    */
    public function getUserkeyInput(){
        return $this->forminputs[UserGuard::TABLE][UserGuard::FIELD_USER_GUARD_USERKEY];
    }
    
    public function getUserkeyValue(){
        return $this->getInputValue(UserGuard::TABLE, UserGuard::FIELD_USER_GUARD_USERKEY);
    }
    
    public function validateUserkeyInput() {
        $input = $this->getUserkeyInput();
        return $input->validate();
    }
    
    
    
    
    
    

}
