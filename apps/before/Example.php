<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Apps\before;

/**
 * Description of Example
 *
 * @author Luís Pinto / luis.nestesitio@gmail.com
 * Created @Aug 4, 2017
 */
class Example extends \Catrineta\routing\Strainer {

    public static function handle(array $arguments){
        
        self::registryArgs($arguments);
        
        return self::next(true);
    }

}
