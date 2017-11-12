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

use \Model\models\UserHasGroup;

/**
 * Description of UserHasGroupForm
 *
 * @author Luís Pinto / luis.nestesitio@gmail.com
 * Created @2017-11-12 21:13
 * Updated @Updated @2017-11-12 21:13 with columns user_id, user_group *
 */
class UserHasGroupForm extends \Catrineta\form\Form {

    public static function initialize($declare = true){
        $form = new UserHasGroupForm();
        if($declare == true){
            $form->declareInputs();
        }
        return $form;
    }
    
    
    public function declareInputs(){
        $this->queue[] = UserHasGroup::TABLE;
        $this->models[UserHasGroup::TABLE] = new UserHasGroup();
        
        return $this;
    }
    
    public function validate(){
        
        $this->validateUserIdInput();
        $this->validateUserGroupInput();
        
        return $this;
    }
    
    
    
    
    /**
    * Create and return the input associeted with field
    * 
    * @return \lib\form\input\HiddenInput;
    */
    public function setUserIdInput($input = null) {
        if($input == null){
            $input = \Catrineta\form\input\HiddenInput::create(UserHasGroup::FIELD_USER_HAS_GROUP_USER_ID);
        }else{
            $input->setElementId(UserHasGroup::FIELD_USER_HAS_GROUP_USER_ID); 
        }
        
        $this->setFieldInput(UserHasGroup::TABLE, UserHasGroup::FIELD_USER_HAS_GROUP_USER_ID, $input);
        
        return $input;
    }
    
    public function setUserIdDefault($value) {
        $this->setDefault(UserHasGroup::TABLE, UserHasGroup::FIELD_USER_HAS_GROUP_USER_ID, $value);
    }
    
    public function unsetUserIdInput() {
        $this->unsetFieldInput(UserHasGroup::TABLE, UserHasGroup::FIELD_USER_HAS_GROUP_USER_ID);
    }
    
    /**
    * @return \lib\form\input\HiddenInput;
    */
    public function getUserIdInput(){
        return $this->forminputs[UserHasGroup::TABLE][UserHasGroup::FIELD_USER_HAS_GROUP_USER_ID];
    }
    
    public function getUserIdValue(){
        return $this->getInputValue(UserHasGroup::TABLE, UserHasGroup::FIELD_USER_HAS_GROUP_USER_ID);
    }
    
    public function validateUserIdInput() {
        $input = $this->getUserIdInput();
        return $input->validate();
    }
    
    
    
    /**
    * Create and return the input associeted with field
    * 
    * @return \lib\form\input\HiddenInput;
    */
    public function setUserGroupInput($input = null) {
        if($input == null){
            $input = \Catrineta\form\input\HiddenInput::create(UserHasGroup::FIELD_USER_HAS_GROUP_USER_GROUP);
        }else{
            $input->setElementId(UserHasGroup::FIELD_USER_HAS_GROUP_USER_GROUP); 
        }
        
        $this->setFieldInput(UserHasGroup::TABLE, UserHasGroup::FIELD_USER_HAS_GROUP_USER_GROUP, $input);
        
        return $input;
    }
    
    public function setUserGroupDefault($value) {
        $this->setDefault(UserHasGroup::TABLE, UserHasGroup::FIELD_USER_HAS_GROUP_USER_GROUP, $value);
    }
    
    public function unsetUserGroupInput() {
        $this->unsetFieldInput(UserHasGroup::TABLE, UserHasGroup::FIELD_USER_HAS_GROUP_USER_GROUP);
    }
    
    /**
    * @return \lib\form\input\HiddenInput;
    */
    public function getUserGroupInput(){
        return $this->forminputs[UserHasGroup::TABLE][UserHasGroup::FIELD_USER_HAS_GROUP_USER_GROUP];
    }
    
    public function getUserGroupValue(){
        return $this->getInputValue(UserHasGroup::TABLE, UserHasGroup::FIELD_USER_HAS_GROUP_USER_GROUP);
    }
    
    public function validateUserGroupInput() {
        $input = $this->getUserGroupInput();
        return $input->validate();
    }
    
    
    
    
    
    

}
