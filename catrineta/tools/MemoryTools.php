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

use \lib\register\Monitor;

/**
 * Description of MemoryTools
 *
 * @author Luís Pinto / luis.nestesitio@gmail.com
 * Created @Feb 4, 2015
 */
class MemoryTools
{
    /**
     * @return float
     */
    public static function getMemoryUsage()
    {
        return ((memory_get_peak_usage() - Monitor::getMemoryInitial()['mem'])/1024);
    }

    /**
     * @return mixed
     */
    public static function getMemory()
    {
        return memory_get_usage();
    }

    /**
     * @return mixed
     */
    public static function getTimeExecution()
    {
        $t = ((microtime(true) - Monitor::getMemoryInitial()['time']) / 1000000 );
        return number_format($t, 10, '.', ' ');
    }

}
