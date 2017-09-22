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
 * Description of ZipTools
 *
 * @author Luís Pinto / luis.nestesitio@gmail.com
 * Created @Oct 26, 2015
 */
class ZipTools
{
    /**
     * @param $value
     * @param string $country
     * @return bool
     */
    public static function checkZip($value, $country = 'pt')
    {
        $patterns = [
            'at' => '^[0-9]{4,4}$',
            'au' => '^[2-9][0-9]{2,3}$',
            'ca' => '^[a-zA-Z].[0-9].[a-zA-Z].s[0-9].[a-zA-Z].[0-9].',
            'de' => '^[0-9]{5,5}$',
            'ee' => '^[0-9]{5,5}$',
            'nl' => '^[0-9]{4,4}s[a-zA-Z]{2,2}$',
            'in' => '^[0-9]{6,6}$',
            'it' => '^[0-9]{5,5}$',
            'pt' => '^[0-9]{4,4}-[0-9]{3,3}$',
            'se' => '^[0-9]{3,3}s[0-9]{2,2}$',
            'uk' => '^([A-Z]{1,2}[0-9]{1}[0-9A-Z]{0,1}) ?([0-9]{1}[A-Z]{1,2})$',
            'us' => '^[0-9]{5,5}[-]{0,1}[0-9]{4,4}$'
            ];
        if (!array_key_exists($country, $patterns)){
            return false;
        }

        return (bool) preg_match("/" . $patterns[$country] . "/", $value);
    }

}
