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
use \Catrineta\lang\LangTools;

/**
 * Description of Lang
 *
 * @author Luís Pinto / luis.nestesitio@gmail.com
 * Created @Nov 5, 2017
 */
class Translation
{

    private $folder;
    
    private $file;
    
    private $index;

    function __construct($index)
    {
        $parts = $this->setFolder($index);
        $this->file = $parts[0];
        $this->index = $parts[1];
    }
    
    public static function translate($index)
    {
        $str = new Translation($index);
        echo $str->getString();
    }
    
    private function setFolder($index)
    {
        $parts = explode('.', $index);
        if(count($parts) == 2){
            $this->folder = RESOURCES_DIR . DS . 'lang';
            return $parts;
        }else{
            $this->folder = APPS_DIR . $parts[0] . DS . 'lang';
            array_shift($parts);
            return $parts;
        } 
    }
    
    public function getString()
    {
        return LangTools::choice(
                Language::getSequence(), 
                $this->getCollection()
                );
    }
    
    private function getCollection()
    {
        $translations = [];
        foreach (Configurator::getLangs() as $lang){
            $file = $this->folder . DS . $lang . DS . $this->file . '.php';
            if(is_file($file)){
                
                $arr = require $file;
                if(isset($arr[$this->index])){
                    $translations[$lang] = $arr[$this->index];
                }
            }
        }
        return $translations;
    }

}
