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

namespace Catrineta\routing;

/**
 * Description of Strainer
 *
 * @author Luís Pinto / luis.nestesitio@gmail.com
 * Created @Aug 4, 2017
 */
abstract class Strainer implements \Catrineta\routing\middleware\Filterage{

    function __construct() {}
    
    protected static function next($result){
        if($result){
            return true;
        }
        return false;
    }
    
    protected static $arguments = [];

    /**
     * 
     * @param array $arguments
     */
    protected static function registryArgs($arguments = []){
        foreach($arguments as $key=>$argument){
            self::$arguments[$key] = $argument;
        }
    }

}
