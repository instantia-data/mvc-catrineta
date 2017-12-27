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

namespace Catrineta\register;

use \Catrineta\register\Monitor;
use \Catrineta\register\Request;
use \Catrineta\url\UrlRegister;

/**
 * Description of PostRegister
 *
 * @author Luís Pinto / luis.nestesitio@gmail.com
 * Created @Nov 27, 2017
 */
class PostRegister
{

    /**
     *
     */
    public static function registPosts()
    {
        $inputs = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
        Monitor::add(Monitor::FORM, 'POST inputs: ' . count($inputs));
        if (!empty($inputs)) {
            foreach ($inputs as $key => $value) {
                Request::setPost($key, $value);
                Monitor::add(Monitor::FORM, 'POST value: ' . $key . '=' . $value);
            }
        }
        if(isset($inputs['token'])){
            self::parseToken($inputs['token']);
        }
    }
    
    /**
     * @param $token
     */
    public static function parseToken($token)
    {
        $vars = UrlRegister::decUrl($token);
        foreach($vars as $key=>$value){
            Request::setPost($key, $value);
        }
    }

}
