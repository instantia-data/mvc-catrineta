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

use \Model\models\UserLog;

/**
 * Description of UserLogForm
 *
 * @author Luís Pinto / luis.nestesitio@gmail.com
 * Created @2017-09-22 17:25
 * Updated @Updated @2017-09-22 17:25 with columns id, user_id, user_event, timestamp *
 */
class UserLogForm extends \Catrineta\form\Form {

    public static function initialize($declare = true){
        $form = new UserLogForm();
        if($declare == true){
            $form->declareInputs();
        }
        return $form;
    }
    
    
    public function declareInputs(){
        $this->queue[] = UserLog::TABLE;
        $this->models[UserLog::TABLE] = new UserLog();
        
        return $this;
    }
    
    public function validate(){
        
        $this->validateIdInput();
        $this->validateUserIdInput();
        $this->validateUserEventInput();
        
        return $this;
    }
    
    
    
    
    /**
    * Create and return the input associeted with field
    * 
    * @return \lib\form\input\HiddenInput;
    */
    public function setIdInput($input = null) {
        if($input == null){
            $input = \Catrineta\form\input\HiddenInput::create(UserLog::FIELD_USER_LOG_ID);
        }else{
            $input->setElementId(UserLog::FIELD_USER_LOG_ID); 
        }
        
        $this->setFieldInput(UserLog::TABLE, UserLog::FIELD_USER_LOG_ID, $input);
        
        return $input;
    }
    
    public function setIdDefault($value) {
        $this->setDefault(UserLog::TABLE, UserLog::FIELD_USER_LOG_ID, $value);
    }
    
    public function unsetIdInput() {
        $this->unsetFieldInput(UserLog::TABLE, UserLog::FIELD_USER_LOG_ID);
    }
    
    /**
    * @return \lib\form\input\HiddenInput;
    */
    public function getIdInput(){
        return $this->forminputs[UserLog::TABLE][UserLog::FIELD_USER_LOG_ID];
    }
    
    public function getIdValue(){
        return $this->getInputValue(UserLog::TABLE, UserLog::FIELD_USER_LOG_ID);
    }
    
    public function validateIdInput() {
        $input = $this->getIdInput();
        return $input->validate();
    }
    
    
    
    
    
    
    /**
    * Create and return the input associeted with field
    * 
    * @return \lib\form\input\SelectInput;
    */
    public function setUserIdInput($input = null) {
        if($input == null){
            $input = \Catrineta\form\input\SelectInput::create(UserLog::FIELD_USER_LOG_USER_ID)
                ->setModel(\Model\querys\UserQuery::start())
		->setOptionIndex(\Model\models\User::FIELD_USER_ID)->addEmpty()
                ->setRequired(true)
                ->setDefault('null');
        }else{
            $input->setElementId(UserLog::FIELD_USER_LOG_USER_ID); 
        }
        
        $this->setFieldInput(UserLog::TABLE, UserLog::FIELD_USER_LOG_USER_ID, $input);
        
        return $input;
    }
    
    public function setUserIdDefault($value) {
        $this->setDefault(UserLog::TABLE, UserLog::FIELD_USER_LOG_USER_ID, $value);
    }
    
    public function unsetUserIdInput() {
        $this->unsetFieldInput(UserLog::TABLE, UserLog::FIELD_USER_LOG_USER_ID);
    }
    
    /**
    * @return \lib\form\input\SelectInput;
    */
    public function getUserIdInput(){
        return $this->forminputs[UserLog::TABLE][UserLog::FIELD_USER_LOG_USER_ID];
    }
    
    public function getUserIdValue(){
        return $this->getInputValue(UserLog::TABLE, UserLog::FIELD_USER_LOG_USER_ID);
    }
    
    public function validateUserIdInput() {
        $input = $this->getUserIdInput();
        return $input->validate();
    }
    
    
    
    /**
    * Create and return the input associeted with field
    * 
    * @return \lib\form\input\SelectInput;
    */
    public function setUserEventInput($input = null) {
        if($input == null){
            $input = \Catrineta\form\input\SelectInput::create(UserLog::FIELD_USER_LOG_USER_EVENT)
                ->setModel(\Model\querys\UserEventQuery::start())
		->setOptionIndex(\Model\models\UserEvent::FIELD_USER_EVENT_ID)->addEmpty()
                ->setRequired(true)
                ->setDefault('null');
        }else{
            $input->setElementId(UserLog::FIELD_USER_LOG_USER_EVENT); 
        }
        
        $this->setFieldInput(UserLog::TABLE, UserLog::FIELD_USER_LOG_USER_EVENT, $input);
        
        return $input;
    }
    
    public function setUserEventDefault($value) {
        $this->setDefault(UserLog::TABLE, UserLog::FIELD_USER_LOG_USER_EVENT, $value);
    }
    
    public function unsetUserEventInput() {
        $this->unsetFieldInput(UserLog::TABLE, UserLog::FIELD_USER_LOG_USER_EVENT);
    }
    
    /**
    * @return \lib\form\input\SelectInput;
    */
    public function getUserEventInput(){
        return $this->forminputs[UserLog::TABLE][UserLog::FIELD_USER_LOG_USER_EVENT];
    }
    
    public function getUserEventValue(){
        return $this->getInputValue(UserLog::TABLE, UserLog::FIELD_USER_LOG_USER_EVENT);
    }
    
    public function validateUserEventInput() {
        $input = $this->getUserEventInput();
        return $input->validate();
    }
    
    
    

}
