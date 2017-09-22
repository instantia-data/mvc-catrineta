<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

use \Catrineta\url\UrlRegister;
use \Catrineta\url\UrlParser;

/**
 * 
 * @param string $key
 * @return bool|mixed
 */
function get_querystring_part($key){
    return UrlRegister::getGets($key);
}

function part_is_var($part){
    
}
