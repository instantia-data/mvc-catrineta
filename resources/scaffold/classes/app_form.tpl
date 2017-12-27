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

 
namespace Apps\%$nameApp%\model;
 
use \Model\forms\%$modelName%Form;
use \Model\models\%$modelName%;
 
 /**
 * Description of %$className%UtilForm
 *
 * @author Luís Pinto / luis.nestesitio@gmail.com
 * Created @%$dateCreated%
 * Updated @%$dateUpdated% *
 */
class %$className%UtilForm extends \Catrineta\form\MergeForm 
{

    /**
    * Create and return the common object to this class
    *
    * @return %$className%UtilForm;
    */
    public static function initialize(){
        $form = new %$modelName%Form();
        $form->setQueue();
        return $form;
    }

    /**
    * Merge forms and models
    * @return %$className%UtilForm;
    */
    public function setQueue() {
        $this->queue = [%$modelName%::TABLE];
        $this->models[%$modelName%::TABLE] = new %$modelName%();
        $this->forms[%$modelName%::TABLE] = $this->declare%$modelName%Form();
        
        $this->merge();
        
        return $this;
    }

    /**
    *
    * @return %$modelName%Form;
    */
    private function declare%$modelName%Form(){
        $form = %$modelName%Form::initialize();
        
        return $form;
    }



}
