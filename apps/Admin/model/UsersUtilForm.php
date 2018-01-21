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

 
namespace Apps\Admin\model;
 
use \Model\forms\UserForm;
use \Model\models\User;
 
 /**
 * Description of UsersUtilForm
 *
 * @author Luís Pinto / luis.nestesitio@gmail.com
 * Created @%$dateCreated%
 * Updated @%$dateUpdated% *
 */
class UsersUtilForm extends \Catrineta\form\MergeForm  
{

    /**
    * Create and return the common object to this class
    *
    * @return UsersUtilForm;
    */
    public static function initialize(){
        $form = new UsersUtilForm();
        $form->setQueue();
        return $form;
    }

    /**
    * Merge forms and models
    * @return UsersUtilForm;
    */
    public function setQueue() {
        $this->queue = [User::TABLE];
        $this->models[User::TABLE] = new User();
        $this->forms[User::TABLE] = $this->declareUserForm();
        
        $this->merge();
        
        return $this;
    }

    /**
    *
    * @return UserForm;
    */
    private function declareUserForm(){
        $form = UserForm::initialize();
        
        return $form;
    }



}
