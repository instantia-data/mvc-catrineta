<?php

/*
 * Copyright (C) 2017 Luís Pinto <luis.nestesitio@gmail.com>
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

namespace Catrineta\framework;

use \Catrineta\register\CatExceptions;
use \Twig_Loader_Filesystem;
use \Twig_Environment;

use \Catrineta\routing\Routing;

/**
 * Description of View
 *
 * @author Luís Pinto / luis.nestesitio@gmail.com
 * Created @Jul 30, 2017
 */
class View {

    private $view;
    
    private $twig;

    function __construct($view) {
        if($this->testFile($view) == true){
            $this->view = $view;
        }
        
    }

    public function loadTwig() {
        
        $loader = new Twig_Loader_Filesystem(
                [VIEW_DIR, $this->getFolderView()]
        );
        // set up environment
        $params = [];
        $this->twig = new Twig_Environment($loader, $params);
        // ...
    }
    
    public function render($data, $view = null){
        if($view != null && $this->testFile($view) == true){
            $this->view = $view;
        }
        return $this->twig->render($this->view, $data);
    }
    
    private function getFolderView(){
        return APPS_DIR . Routing::getFolder() . DS . 'view' . DS;
    }
    
    private function testFile($view){
        if(empty($view)){
            throw new CatExceptions('No view is defined', CatExceptions::CODE_VIEW);
        }
        $file = APPS_DIR . Routing::getFolder() . DS . 'view' . DS . $view;
        if(!is_file($file)){
            throw new CatExceptions('File is not valid for ' . $file, CatExceptions::CODE_VIEW);
        }
        
        return true;
    }

}
