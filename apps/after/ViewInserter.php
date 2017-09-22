<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Apps\after;

/**
 * Description of ViewProvider
 *
 * @author Luís Pinto / luis.nestesitio@gmail.com
 * Created @Aug 4, 2017
 */
class ViewInserter extends \Catrineta\framework\Inserter {


    public function boot()
    {
        \Apps\after\MenuInserter::run();
    }

}
