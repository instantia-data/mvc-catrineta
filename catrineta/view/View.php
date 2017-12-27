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

namespace Catrineta\view;

use \Catrineta\register\CatExceptions;
use \Twig_Loader_Filesystem;
use \Twig\TwigFunction;
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

    /**
     * Test the view file
     * @param string $view
     */
    function __construct($view) {
        if($this->testFile($view) == true){
            $this->view = $view;
        }
        
    }

    /**
     * Constructor.
     *
     * Available options:
     *
     *  * debug: When set to true, it automatically set "auto_reload" to true as
     *           well (default to false).
     *
     *  * charset: The charset used by the templates (default to UTF-8).
     *
     *  * base_template_class: The base template class to use for generated
     *                         templates (default to Twig_Template).
     *
     *  * cache: An absolute path where to store the compiled templates,
     *           a Twig_Cache_Interface implementation,
     *           or false to disable compilation cache (default).
     *
     *  * auto_reload: Whether to reload the template if the original source changed.
     *                 If you don't provide the auto_reload option, it will be
     *                 determined automatically based on the debug value.
     *
     *  * strict_variables: Whether to ignore invalid variables in templates
     *                      (default to false).
     *
     *  * autoescape: Whether to enable auto-escaping (default to html):
     *                  * false: disable auto-escaping
     *                  * html, js: set the autoescaping to one of the supported strategies
     *                  * name: set the autoescaping strategy based on the template name extension
     *                  * PHP callback: a PHP callback that returns an escaping strategy based on the template "name"
     *
     *  * optimizations: A flag that indicates which optimizations to apply
     *                   (default to -1 which means that all optimizations are enabled;
     *                   set it to 0 to disable).
     *
     * @param array $params An array of options
     */
    public function loadTwig() {
        
        //Twig_LoaderInterface $loader with
        //array of paths where to look for templates
        $loader = new Twig_Loader_Filesystem(
                [VIEW_DIR, $this->getFolderView()]
        );
        // Twig Constructor
        $this->twig = new Twig_Environment($loader, [
            'debug' => true,
        ]);
        
        $this->twig->addExtension(new \Twig_Extension_Debug());
        
        $this->addFunctions();
                
    }
    
    private function addFunctions()
    {
        $this->twig->addFunction(new TwigFunction('lang', function ($index) {
            \Catrineta\lang\Translation::translate($index);
        }));
    }
    
    /**
     * 
     * @param mixed $data
     * @param string $view
     * @return string The rendered template
     */
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
