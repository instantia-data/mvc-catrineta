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

namespace Catrineta\tools;

use \ReflectionClass;

/**
 * Description of ClassInfo
 *
 * @author Luís Pinto / luis.nestesitio@gmail.com
 * Created @Sep 1, 2017
 */
class ClassInfo
{

    private $info;
    
    private $class;

    function __construct($class)
    {
        $this->class = $class;
        $this->info = new ReflectionClass($class);
    }
    
    public function getClassComment($key = null)
    {
        $doc = $this->info->getDocComment();
        
        if($key == null){
            return $this->getComment($doc);
        }else{
            return $this->infoComment($doc, $key);
        }
        
        
    }
    
    private $doc_lines = [];
    
    /**
     * 
     * @param string $comment
     * @return array
     */
    private function getMatches($comment)
    {
        $matches1 = [];
        $pattern = "#((@)[a-zA-Z]+\s*[a-zA-Z0-9, ()_].*)#";
        preg_match_all($pattern, $comment, $matches1, PREG_PATTERN_ORDER);
        
        $matches2 = [];
        $pattern = "#((Created|Updated)\s(@)[0-9\-]{10}\s[0-9\:]{5})[^\n]*#";
        preg_match_all($pattern, $comment, $matches2, PREG_PATTERN_ORDER);
        
        $this->doc_lines = array_merge($matches1[0], $matches2[0]);
        
        return $this->doc_lines;
    }
    
    private function getComment($comment)
    {
        $infos = [];
        $matches = $this->getMatches($comment);
        foreach($matches as $match){
            $infos[] = $match;
        }
        return $infos;
        
    }
    
    /**
     * 
     * @param string $comment The comment of a class
     * @param string $key Begin of line
     * @return string The line that matches key
     */
    private function infoComment($comment, $key)
    {
        $matches = $this->getMatches($comment);
        foreach($matches as $match){
            if(strpos($match, $key) === 0){
                return trim(str_replace($key, '', $match));
            }
        }
        return "There is no info $key about this class";
        
    }
    
    /**
     * Get all the line of the class comment
     * @param string $key
     * @return array
     */
    public function getLines($key){
        $lines = [];
        foreach($this->doc_lines as $line){
            if(strpos($line, $key) === 0){
                $lines[] = $line;
            }
        }
        return $lines;
    }
    
    
    /**
     * 
     * @param string $name
     * @return array An array of default properties, with the key being the name of
     * the property and the value being the default value of the property or <b>NULL</b>
     * if the property doesn't have a default value. The function does not distinguish
     * between static and non static properties and does not mind about visibility modifiers.
     */
    public function getProperty($name = null)
    {
        $prop = $this->info->getDefaultProperties();
        if (null == $name) {
            return $prop;
        } else {
            return $prop[$name];
        }
    }

}
