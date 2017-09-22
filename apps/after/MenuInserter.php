<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Apps\after;


/**
 * Description of MenuInserter
 *
 * @author Luís Pinto / luis.nestesitio@gmail.com
 * Created @Aug 4, 2017
 */
class MenuInserter extends \Catrineta\framework\InserterApp {

    /**
     * launch this inserter
     */
    public static function run(){
        $job = new MenuInserter();
        $job->compose();
        
    }
    
    /**
     * add tags to template
     * $this->add('tag', 'value');
     */
    public function compose(){
        $this->add('welcome', 'Welcome!');
    }

}
