<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

use \Catrineta\register\CatExceptions;

/**
 * return messages by exception code
 */
return [
    //route exception
    CatExceptions::CODE_ROUTE=>[
        'en'=>['title'=>'Route error', 'text'=>'Error with routing']
    ],
    //sql exception
    CatExceptions::CODE_SQL=>[
        'en'=>['title'=>'Sql query error', 'text'=>'Error with query in database']
    ]
];