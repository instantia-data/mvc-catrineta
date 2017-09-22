<?php

/*
 * Copyright (C) 2017 Luis Pinto <luis.nestesitio@gmail.com>
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

namespace Catrineta\console;

/**
 * Description of Console
 *
 * @author Luís Pinto / luis.nestesitio@gmail.com
 * Created @Sep 1, 2017
 */
class Console
{
    
    const OPT_H = 'h';
    const OPT_HELP = 'help';
    
    const OPT_T = 't';
    const OPT_TASK = 'task';
    
    const OPT_N = 'n';
    const OPT_NAME = 'name';
    
    const OPT_A = 'a';
    const OPT_APP = 'app';
    
    const OPT_M = 'm';
    const OPT_MODEL = 'model';
    
    const OPT_O = 'o';
    const OPT_OPTION = 'option';
    
    
    public static $options = [];
    
    private $cond = [
        self::OPT_H=>':'
    ];


    /**
     * Collect options available from console_options.php
     * and return array of option / argument pairs, or FALSE on failure.
     * Define static $options
     * 
     * @return array|boolean
     */
    public function options()
    {
        //Gets options from the command line argument list
        self::$options = require_once (BOOT_DIR . 'console_options.php');


        $shortopts = "";
        
        foreach (self::$options as $char => $name) {
            $cond = (isset($this->cond[$char]))? $this->cond[$char] : ":";
            $shortopts .= $char . $cond;
            $longopts[] = $name . $cond;
        }
        /*
        $shortopts = "";
        $shortopts .= "f:";  // Required value
        $shortopts .= "v::"; // Optional value
        $shortopts .= "abc"; // These options do not accept values
         * 
         */

        return getopt($shortopts, $longopts);
    }
    

}
