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

use \Catrineta\routing\Routing;

/**
 * 
 * @param string $arg The argument for option -t
 * @param string $task The Task class to be fired
 * 
 * @return \Catrineta\routing\Task
 */
function route_task($arg, $task){
    return Routing::task($arg, $task);
}

/**
 * 
 * @param string $uri
 * @param string $action
 * @return \Catrineta\routing\Route
 */
function route_get($uri, $action){
    return Routing::get($uri, $action);
}

/**
 * 
 * @param string $uri
 * @param string $action
 * @return \Catrineta\routing\Route
 */
function route_post($uri, $action){
    return Routing::post($uri, $action);
}

/**
 * 
 * @param array $attributes
 * @param mixed $routes
 * @return null
 */
function route_group(array $attributes, $routes){
    return Routing::group($attributes, $routes);
}
