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

namespace Catrineta\tools;

/**
 * Description of ObTool
 *
 * @author Luís Pinto / luis.nestesitio@gmail.com
 * Created @Jul 17, 2015
 */
class ObTool
{
    /**
     * @return mixed
     */
    public static function obStart()
    {
        set_time_limit(9640);
        ini_set('memory_limit', '3048M');
        $start_time = microtime(true);
        ob_start();
        ignore_user_abort(true);

        // Get the content of the output buffer
        ob_end_clean();// Close current output buffer
        self::outputLine("BEGIN");
        return $start_time;
    }

    /**
     * @param string $string
     */
    public static function outputLine($string = '')
    {
        echo " " . $string . "<br />";
        ob_flush();
        flush();
        usleep(1);
    }

    /**
     * @param $string
     */
    public static function output($string)
    {
        echo " " . $string;
    }

    /**
     * @param string $string
     */
    public static function obEnd($string = '')
    {
        self::outputLine($string);
        ob_end_flush();
    }

}
