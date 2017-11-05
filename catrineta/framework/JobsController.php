<?php

/*
 * Copyright (C) 2017 Luís Pinto <luis.nestesitio@gmail.com>
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

namespace Catrineta\framework;

use \Catrineta\view\View;

/**
 * Description of ParentController
 *
 * @author Luís Pinto / luis.nestesitio@gmail.com
 * Created @Jul 30, 2017
 */
class JobsController {
    
    /**
     * @var array
     */
    private $data = [];
    
    /**
     * Stores data to pass to template engine
     *
     * @param $tag
     * @param $data
     */
    protected function add($tag, $data)
    {
        $this->data[$tag] = $data;
    }
    
    /**
     * 
     * @param array $data
     */
    public function dumpData($data = []) {
        foreach ($data as $var => $value) {
            $this->add($var, $value);
        }
    }

    private $view = null;
    
    /**
     *
     * @param string $filename
     * @return boolean
     */
    public function setView($filename)
    {
        $this->view = $filename;
    }


    /**
     * Output rendered template
     * @return string The rendered template
     */
    public function dispatch()
    {
        //test view file
        $view = new View($this->view);
        //load the Twig
        $view->loadTwig();
        // return the view
        return $view->render($this->data);
    }
}
