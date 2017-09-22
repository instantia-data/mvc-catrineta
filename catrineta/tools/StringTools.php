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

use \plugins\Transliterator\Transliterator\Transliterator;

/**
 * Description of StringTools
 *
 * @author Luís Pinto / luis.nestesitio@gmail.com
 * Created @Jan 27, 2015
 */
class StringTools
{
    /**
     * @param $haystack
     * @param $needle
     * @return mixed
     */
    public static function getStringUntilLastChar($haystack, $needle)
    {
        return str_replace(substr(strrchr($haystack, $needle), 1), '', $haystack);
    }

    /**
     * @param $haystack
     * @param $needle
     * @return mixed
     */
    public static function getStringAfterLastChar($haystack, $needle)
    {
        return str_replace(strstr($haystack, $needle, true) . $needle, '', $haystack);
    }

    /**
     * @param $string
     * @param array $removes
     * @return mixed
     */
    public static function replaceFromBegin($string, $removes = [])
    {
        foreach($removes as $remove){
            $string = substr($string, strlen($remove));
        }
        return $string;
    }

    /**
     * @param $string
     */
    public static function output($string)
    {
        echo " " . $string;
    }

    /**
     * @param $string
     */
    public static function outputLine($string)
    {
        echo " " . $string . "<br />";
        ob_flush();
        flush();
        usleep(1);
    }

    /**
     * Perform a regular expression search and replace
     * @param String $string
     *
     * @return String
     */
    public static function slugify($string)
    {

    $slug =  Transliterator::transliterate($string);
    
    $slug = preg_replace("/[^a-zA-Z0-9\/_|+ -]/", '', $slug);
    $slug = strtolower(trim($slug, '-'));
        //$pattern, $replacement, $subject, $limit = -1, &$count = null
    $slug = preg_replace("/[\/_|+ -]+/", '-', $slug);

    return $slug;
    }

    /**
     * @param $stringValue
     * @return bool
     */
    public static function cleanStringCode($stringValue = null)
    {
        // chars to trim
        $charList = ['*', '#', '$', '%', '&', '/', '(', ')', '=', '?', '»', '«', '!', '\\', '\"', '\'', '"', '\''];

        if ($stringValue != null) {
            return str_replace($charList, '', $stringValue);
        }

        return false;
    }

    /**
     * @param $txt
     * @return mixed
     */
    public static function cleanTIN($txt)
    {
        return \Catrineta\tools\TinTools::cleanTIN($txt);
    }

    /**
     * @param $txt
     * @return mixed
     */
    public static function trimZipCode($txt)
    {
        return substr(preg_replace("/[^0-9-]/i", "", $txt), 0, 8);
    }

    /**
     * @param $name
     * @return mixed
     */
    public static function ucString($name)
    {
        $name = strtolower($name);
        $name = mb_convert_case($name, MB_CASE_TITLE, "UTF-8");
        
        $name = str_replace([' Da ', ' De ', ' Do ', ' E ', '?'], [' da ', ' de ', ' do ', ' e ', ' '], $name);
        return $name;

    }
    
    /**
     * Encode string or array to UTF-8
     *  
     * @param array|string $data
     * @return mixed
     */
    public static function encodeToUtf8($data){
        $str =  (is_array($data)) ? implode('; ', $data) : $data;
        if(mb_detect_encoding($str, 'UTF-8') != false){
            return $data;
        }
        if(mb_detect_encoding($str, 'ISO-8859-1') != false){
            $str = iconv('ISO-8859-1', 'UTF-8', $str);
            return (is_array($data))? explode('; ', $str) : $str;
        }
        return $data;
    }
    
    /**
     * 
     * @param string $args
     * @return array
     */
    public static function argsToArray($args){
        $args = explode(', ', $args);
        $arr = [];
        foreach($args as $arg){
            if(strpos($arg, '=>')){
                list($key, $label) = explode('=>', $arg);
                $arr[$key] = $label;
            }else{
                $arr[] = $arg;
            }
            
        }
        return $arr;
    }
    
    /**
     * 
     * @param string $args
     * @return string
     */
    public static function argsToString($args){
        return str_replace(['\'','"'], '', $args);
    }
    
    /**
     * 
     * @param string $text
     * @param string $focus
     * @param string $class
     * 
     * @return string
     */
    public static function insertSpan($text, $focus, $class){
        $replaced = '<span class="'.$class.'">' . $focus . '</span>';
        $text = str_replace($focus, $replaced, $text);
        return $text;
    }

}
