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

use \Catrineta\register\Informant;


/**
 * Description of Monitor
 *
 * @author Luís Pinto / luis.nestesitio@gmail.com
 * Created @Jul 28, 2017
 */
class Monitor extends \Catrineta\register\FrameworkMonitor 
{


    /**
     * @var array
     */
    protected static $memory_ini = [];

    /**
     * @param $type
     * @param $message
     * @return Monitor
     */
    public static function add($type, $message)
    {
        Informant::setMonitor($type, $message);
    }
    
    /**
     * 
     * @param string $message
     */
    public static function setWarning($message)
    {
        Informant::setMonitor(self::WARNING, $message);
    }

    /**
     * 
     * @param type $type
     * @param type $message
     * @return type
     */
    public static function write($type, $message)
    {
        $class = 'dev_' . strtolower($type);
        $br = ($type == self::QUERY) ? '<br />' : '';
        return '<div class="dm ' . $class . ' alert ' . self::getAlert($type) . '">'
                . '<b>' . $type . ':</b> ' . $br . $message . '</div>';
        }
    
    private static function getAlert($type){
        $type = 'alert-info';
        if($type == self::WARNING){
            $type = 'alert-warning';
        }
        return $type;
    }

        /**
     * 
     * @param type $time
     */
    public static function setMemoryInitial($time) 
    {
        self::$memory_ini['memory'] = memory_get_usage();
        self::$memory_ini['time'] = $time;
    }
    
    /**
     * @var
     */
    public $type;
    /**
     * @var
     */
    public $message;

    /**
     * Monitor constructor.
     * @param $type
     */
    public function __construct($type)
    {
        $this->type = $type;
    }
    
    /**
     * Create message for debugging
     * 
     * @param $type
     * @param $message
     * @return Monitor
     */
    public static function create($type, $message)
    {
        $msg = new Monitor($type);
        $msg->message = $message;
        return $msg;
    }
    
    

}
