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

namespace Catrineta\console\crud;

/**
 * Description of ParseLoop
 *
 * @author Luís Pinto / luis.nestesitio@gmail.com
 * Created @Sep 15, 2017
 */
class ParseLoop
{

    private $output = '';
    
    public $data = [];

    function __construct($output)
    {
        $this->output = $output;
    }
    
    /**
     * 
     * @param string $index
     * @param array $data
     */
    public function setData($index, $data)
    {
        $this->data[$index][] = $data;
    }
    
    const PATTERN_WHILE = "/{@while [^}]+\}/";
    
    const PATTERN_ENDWHILE = "{@endwhile;}";

    /**
     * 
     * Process the output
     * 
     * @return string The string processed
      */
    public function parseWhile(){
        $matches = [];
        if (preg_match(self::PATTERN_WHILE, $this->output)) {
            preg_match_all(self::PATTERN_WHILE, $this->output, $matches, PREG_SET_ORDER);
            foreach ($matches as $match) {

                list($vector, $tag) = explode(' in ', self::getCondition($match[0]));
                
                $piece = self::getPiece($this->output, $match[0]);
                $string = self::buildPieces($tag, $vector, $piece);
                
                $start = strpos($this->output, $match[0]);
                $strlength = strlen($match[0]) + strlen($piece) + strlen(self::PATTERN_ENDWHILE);
                
                $this->output = substr_replace($this->output, $string, $start, $strlength);

            }
        }
        
        return $this->output;
    }
    
    /**
     * Get the condition to be tested
     * @param string $match The template tag
     * @return string The condition
     */
    private function getCondition($match){
        $match = strstr($match, '(');
        $match = substr($match, 1, strpos($match, ')') - 1);
        
        return $match;
    }
    
    /**
     * Strip the string to be looped from the html output
     * @param string $output The all HTML
     * @param string $match The template tag
     * @return string The piece to be processed
     */
    private function getPiece($output, $match){
        $piece = substr($output, strpos($output, $match));
        $piece = substr($piece, 0, strpos($piece, self::PATTERN_ENDWHILE));
        return str_replace($match, '', $piece);
    }
    
    /**
     * Loop the array data $tag[] and process the string
     * @param string $tag The name for the array data
     * @param string $vector The name for each array element
     * @param string $piece The HTML to be processed
     * @return string The all string string looped and processed
     */
    private function buildPieces($tag, $vector, $piece){
        if(!isset($this->data[$tag])){
            return false;
        }
        $var = $this->data[$tag];
        $html = '';
        if ($var != null && is_array($var)) {
            foreach ($var as $row) {
                $string = $piece;
                foreach ($row as $k => $value) {
                    $string = str_replace('{' . $vector . '.' . $k . '}', $value, $string);
                }
                $html .= $string;
            }
        }
        return $html;
    }

}
