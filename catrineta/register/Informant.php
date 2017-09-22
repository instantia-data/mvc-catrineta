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

use \Catrineta\register\Monitor;

/**
 * Description of Informant
 * 
 * Class to throw information to user
 *
 * @author Luís Pinto / luis.nestesitio@gmail.com
 * Created @Jul 28, 2017
 */
class Informant {

    /**
     * @var array
     */
    private static $error_messages = [];
    /**
     * @var array
     */
    private static $user_messages = [];
    /**
     * @var array
     */
    private static $dev_messages = [];
    
    /**
     * Add a Monitor message to $dev_messages array
     * @param $type
     * @param $value
     * @param $key
     */
    public static function setMonitor($type, $value, $key = null)
    {
        if (null == $key) {
            $key = count(self::$dev_messages);
        }

        self::$dev_messages [$key] = Monitor::create($type, $value);
    }

    public static function setUserMessage($code)
    {
        $messages = require_once (CONFIG_DIR . 'error_messages.php');
        $_SESSION['message'] = ['title' => $messages[$code]['en']['title'], 'text' => $messages[$code]['en']['text']];
    }

    /**
     * 
     * @param string $message
     */
    public static function setWarning($message)
    {
        self::setMonitor(Monitor::WARNING, $message);
        self::$error_messages[] = ['title' => 'Warning', 'text' => $message];
    }

    /**
     * 
     * @return string
     */
    public static function outputDev()
    {
        $string = '';
        foreach(self::$dev_messages as $message){
            $string .= Monitor::write($message->type, $message->message);
        }
        
        return $string;
    }

}
