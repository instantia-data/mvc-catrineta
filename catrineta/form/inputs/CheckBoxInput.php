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

namespace Catrineta\form\input;

/**
 * Description of CheckInput
 *
 * @author Luís Pinto / luis.nestesitio@gmail.com
 * Created @May 11, 2015
 */
class CheckBoxInput extends \Catrineta\form\Input
{
    /**
     * @param String $field The db table field name for reerence to input
     * @return CheckBoxInput
     */
    public static function create($field = null)
    {
        $obj = new CheckBoxInput($field, $field);
        return $obj;
    }

    /**
     * @return string
     */
    public function parseInput()
    {
        $this->attributes();
        /*' <input type="checkbox" name="vehicle" value="Bike">I have a bike<br> '*/

        $this->input = '<input type="checkbox" ' . implode(' ', $this->attributes) . ' />' . $this->value;
        $this->input .= '<a class="clear-input" data-id="'.$this->elemid.'"><span class="glyphicon glyphicon-refresh"></span></a>';
        return $this->input;
    }

}
