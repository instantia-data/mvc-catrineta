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

namespace Apps\Admin\control;

use \Apps\Admin\model\UsersUtilQueries;
use \Apps\Admin\model\UsersUtilForm;

/**
 * Description of Users
 *
 * @author Luís Pinto / luis.nestesitio@gmail.com
 * Created @Nov 24, 2017
 */
class UsersController extends \Catrineta\framework\control\BackendController
{


    function __construct()
    {
        $this->add('sitetitle', 'Backend Catrineta');
    }
    
    public function index()
    {
        $this->add('heading', 'Users management');
        $this->add('list', UsersUtilQueries::getUsers()->find());
        $this->setView('users.html');
    }
    
    public function create()
    {
        $this->add('heading', 'New user');
        $this->setView('users/form.html');
    }
    
    public function edit()
    {
        $this->add('heading', 'User edit');
        $this->setView('users/form.html');
        $form = UsersUtilForm::initialize();
        $this->add('form', $form->render());
    }

}
