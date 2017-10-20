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

namespace Catrineta\register;

use \Catrineta\register\Configurator;
use \Catrineta\register\Informant;
use \Catrineta\register\Monitor;
use \Exception;

/**
 * Description of CatExceptions
 *
 * @author Luís Pinto / luis.nestesitio@gmail.com
 * Created @Jul 22, 2017
 */
class CatExceptions extends Exception {

    /**
     * Redefine the exception so message isn't optional
     * @param string $message
     * @param int $code
     * @param Exception $previous
     */
    public function __construct($message, $code = 0, Exception $previous = null) {
        // some code
    
        // make sure everything is assigned properly
        parent::__construct($message, $code, $previous);
    }

    // custom string representation of object
    public function __toString() {
        //return __CLASS__ . " [{$this->code}]: {$this->message}\n";
        return "-> [{$this->code}]: {$this->message}\n";
    }

    public function output() {
        if(Configurator::getDevMode()){
            Monitor::setWarning("-> [{$this->code}]: {$this->message}\n");
        }else{
            Informant::setUserMessage($this->code);
            header('/error');
            exit();
        }
        
    }
    
    /**
     * 
     */
    const CODE_ROUTE = '301';
    
    /**
     * 
     */
    const CODE_VIEW = '302';
    
    /**
     * 
     */
    const CODE_SQL = '303';
    
    /**
     * 
     */
    const CODE_ORM = '304';

}
