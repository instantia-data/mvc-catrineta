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

use \Catrineta\framework\control\JobsController;

/**
 * Description of Inserter
 * Insert data from ViewProvider after controller process
 *
 * @author Luís Pinto / luis.nestesitio@gmail.com
 * Created @Aug 4, 2017
 */
class Inserter {

    protected static $data = [];
    
    protected $controller = null;
    
    /**
     * 
     * @param JobsController $controller
     */
    function __construct(JobsController $controller) {
        self::$data = [];
        $this->controller = $controller;
        
    }
    
    /**
     * Stores data to pass to template engine
     *
     * @param string $tag
     * @param mixed $data
     */
    public static function add($tag, $data)
    {
        self::$data[$tag] = $data;
    }
    
    /**
     * 
     */
    public function register(){
        $this->controller->dumpData(self::$data);
    }

}
