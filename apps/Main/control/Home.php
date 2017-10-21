<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Apps\Main\control;

use \Model\querys\UserQuery;

/**
 * Description of Home
 *
 * @author Luís Pinto / luis.nestesitio@gmail.com
 * Created @Jul 23, 2017
 */
class Home extends \Catrineta\framework\FrontController {

    public function index(){
        
        $user = UserQuery::init()->filterByName('auto')
                ->joinUserStatus()->selectName('status')->filterByName('Active')->endUse()
                ->findOneOrCreate();
        //var_dump($user->get());
         
        $this->setView('home.html');
    }

}
