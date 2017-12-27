<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Catrineta\url;

use \Catrineta\register\Configurator;

/**
 * Description of UrlRegister
 *
 * @author Luís Pinto / luis.nestesitio@gmail.com
 * Created @Jul 14, 2017
 */
class UrlRegister {

    /**
     * @var array
     */
    private static $gets = [];
    
    const KEY_MAIN = '_url';


    /**
     * UrlRegister constructor.
     */
    private function __construct() {}


    /**
     * @return string
     */
    private static function getQuerySring()
    {
        $query = [];
        $query = filter_input_array(INPUT_GET, FILTER_SANITIZE_STRING);
        if (!empty($query)) {
            foreach ($query as $key => $value) {
                self::$gets[$key] = $value;
            }
            $querystring = http_build_query(self::$gets);
            return str_replace(['%2F'], ['/'], $querystring);
        } else {
            return '';
        }
    }

    /**
     * Sanitize the url
     * @return string The url sanitized
     */
    public static function getUrlRequest()
    {
        $get = filter_input(INPUT_GET, self::KEY_MAIN, FILTER_SANITIZE_SPECIAL_CHARS);
        $_url = isset($get) ? preg_replace('/^'.self::KEY_MAIN.'=(.*)/','$1',self::getQuerySring()) : '';
        //echo $_url . '+' . $_SERVER['HTTP_REFERER'];
        return $_url;
    }


    /**
     * @param $key
     * @return bool|mixed
     */
    public static function getGets($key = null)
    {
        if(null == $key){
            return self::$gets;
        }
        return (isset(self::$gets [$key])) ? self::$gets [$key] : false;
    }
    
    /**
     * Returns the main part of url without query string (the part after ?)
     * @return string
     */
    public static function getMainPart(){
        return (isset(self::$gets [self::KEY_MAIN]))?
            self::$gets [self::KEY_MAIN] : '';
    }
    
    /**
     * @param $string
     * @return mixed
     */
    public static function encUrl($string)
    {
        $key = Configurator::getConfig()->key;
        $encrypted = base64_encode(mcrypt_encrypt(MCRYPT_RIJNDAEL_256, md5($key), $string, MCRYPT_MODE_CBC, md5(md5($key))));
        return urlencode($encrypted);
    }

    /**
     * @param $string
     * @return mixed
     */
    public static function decUrl($string)
    {
        $key = Configurator::getConfig()->key;
        $encrypted = $string;
        $decrypted = rtrim(mcrypt_decrypt(MCRYPT_RIJNDAEL_256, md5($key), base64_decode($encrypted), MCRYPT_MODE_CBC, md5(md5($key))), "\0");

        return json_decode(trim($decrypted));
    }

}

