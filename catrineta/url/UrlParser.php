<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Catrineta\url;

/**
 * Description of UrlParser
 *
 * @author Luís Pinto / luis.nestesitio@gmail.com
 * Created @Jul 14, 2017
 */
class UrlParser {
    

    /** 
     * Define the request as object
     * @param string $url
     * @return \stdClass
     */
    public static function parseRequest($url){
        $request = new \stdClass();
        //The querystring (part after ?)
        $querystring = self::getQueryString($url);
        $request->querystring = $querystring;
        //strip the query string
        $url = self::stripQueryString($url);
        //strip the last trail
        $url = self::stripLastTrail($url);
        //define array with trails (/)
        $parts = explode('/', $url);
        //this is an array of objects
        $request->parts = self::defineUrlObject($parts);
        //property sequence to compare with each route sequence
        $request->sequence = self::sequence($request->parts);
        //return
        return $request;
    }
    
    /**
     * @param string $url
     * @return string
     */
    public static function stripLastTrail($url){
        if(empty($url)){ 
            $url = '/';
        }elseif(substr($url, -1, 1) == '/'){
            $url = substr($url, 0, -1);
        }
        return $url;
    }
    
    /**
     * Define an array of objects
     * @param array $parts
     * @return array
     */
    private static function defineUrlObject($parts){
        $request = [];
        
        foreach($parts as $key=>$part){
            $request[$key] = self::fillPart($part, $key);
        }
        
        return $request;
    }
    
    /**
     * Decompose each part as object with various properties
     * 
     * @param type $content
     * @param type $key
     * @return \stdClass
     */
    private static function fillPart($content, $key){
            $part = new \stdClass();
            //just a number as index
            $part->key = $key;
            //the content
            $part->content = $content;
            //if(empty($content)){$part->content = '/'; }
            //define type
            $part->type = self::getType($content);
            //the property to compose the object sequence
            $part->frame = ($part->type == 'string')? $content : $part->type;
            
            return $part;
    }
    
    public static function sequence($parts){
        $sequence = '';
        foreach($parts as $part){
            $sequence .= '/' . $part->frame;
        }
        return substr($sequence, 1);
    }

    /**
     * 
     * @param string $string
     * @return string
     */
    public static function getType($string) {
        if (is_numeric($string)) {
            return 'numeric';
        }
        if(strpos($string, '.htm')){
            return 'canonical';
        }
        
        return 'string';
    }
    
    /**
     * 
     * @param type $string
     * 
     * @return array|null
     */
    public static function partIsVar($string){
        //echo $string . '||';
        $obj = new \stdClass();
        if(strpos($string, '{') === 0 && substr($string, -1, 1) == '}'){
            $string = str_replace(['{','}'], '', $string);
            
            if (strpos($string, ':')) {

                list($varname, $type) = explode(':', $string);
                $obj->varname = $varname;
                if ($type == 'd') {
                    $obj->type = 'numeric';
                } elseif ($type == 'w') {
                    $obj->type = 'variable';
                } elseif ($type == 'htm') {
                    $obj->type = 'canonical';
                }
            }else{
                $obj->type = 'string';
                $obj->varname = $string;
            }
        }else{
            //echo $string . '+';
            $obj->type = self::getType($string);
            $obj->folder = $string;
        }
        return $obj;
    }

    /**
     * 
     * @param string $url
     * @return string
     */
    public static function stripQueryString($url){
        
        $query = strstr($url, '?');
        return str_replace($query, '', $url);
    }
    
    /**
     * 
     * @param string $url
     * @return array
     */
    public static function getQueryString($url){
        
        $query = strstr($url, '?');
        $query = str_replace('?', '', $query);
        
        return explode('&', $query);
    }

        /**
     * @param $string
     * @return mixed
     */
    public static function encUrl($string)
    {
        $key = $this->getKey();
        $encrypted = base64_encode(mcrypt_encrypt(MCRYPT_RIJNDAEL_256, md5($key), $string, MCRYPT_MODE_CBC, md5(md5($key))));
        return urlencode($encrypted);
    }

    /**
     * @param $string
     * @return mixed
     */
    public static function decUrl($string)
    {
        $key = $this->getKey();
        $encrypted = $string;
        $decrypted = rtrim(mcrypt_decrypt(MCRYPT_RIJNDAEL_256, md5($key), base64_decode($encrypted), MCRYPT_MODE_CBC, md5(md5($key))), "\0");

        return json_decode(trim($decrypted));
    }
    
    private function getKey(){
        $arr = require_once (CONFIG_DIR . 'configs.php');
        return $arr['personal_key'];
    } 

}
