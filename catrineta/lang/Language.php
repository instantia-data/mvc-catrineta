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

namespace Catrineta\lang;

use \Catrineta\register\Configurator;

/**
 * Description of Language
 *
 * @author Luís Pinto / luis.nestesitio@gmail.com
 * Created @Nov 24, 2017
 */
class Language
{
    
    private static $collection = [];
    
    private static $sequence = [];

    public static function setLang(){
        
        self::$sequence['http'] = self::getHttpLanguage();
        self::$sequence['default'] = self::getCollection();
        
    }
    
    public static function getSequence()
    {
        return self::$sequence;
    }
    
    private static function getCollection()
    {
        $default = null;
        foreach (Configurator::getLangs() as $key => $value) {
            self::$collection[] = $value;
            if($key == 'default'){
                $default = $value;
            }
        }
        return $default;
    }
    
    private static function getHttpLanguage() {
        $accept = filter_input(INPUT_SERVER, 'HTTP_ACCEPT_LANGUAGE');
        if ($accept == null) {
            return false;
        } else {
            //string(14) "en-US,en;q=0.5" 
            list($http_str, ) = explode(';', filter_input(INPUT_SERVER, 'HTTP_ACCEPT_LANGUAGE'));

            list(, $lang) = explode(',', $http_str);
        }
        return $lang;
    }

}
