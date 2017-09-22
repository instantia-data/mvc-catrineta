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

namespace Catrineta\console;

/**
 * Description of Task
 *
 * @author Luís Pinto / luis.nestesitio@gmail.com
 * Created @Sep 1, 2017
 */
class Task
{

    protected $name = '';
    
    public function setName($name)
    {
        $this->name = $name;
    }
    
    protected $app = '';
    
    public function setApp($app)
    {
        $this->app = $app;
    }
    
    protected $model = '';
    
    public function setModel($model)
    {
        $this->model = $model;
    }
    
    protected $option = '';
    
    public function setOption($option)
    {
        $this->option = $option;
    }
}
