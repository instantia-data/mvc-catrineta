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

namespace Catrineta\form\inputs;

/**
 * Description of ColorInput
 * Convert input for color picker - jquery plugin $('.input-color').colorpicker();
 * <input type="text" class="input-color" data-color-format="hex" value="GreenYellow">
 *
 * @author Luís Pinto / luis.nestesitio@gmail.com
 * Created @Jan 23, 2017
 */
class ColorInput extends \Catrineta\form\Input {

    /**
     * 
     * @param string $field The name and id for the field
     * @return \lib\form\input\ColorInput
     */
    public static function create($field = null)
    {
        $obj = new ColorInput($field, $field);
        $obj->setInputType(self::TYPE_TEXT);
        //$('.input-color').colorpicker();
        $obj->addClass('input-color');
        $obj->setDataAttribute('data-color-format', 'hex');
        
        return $obj;
    }
    
    /**
     * @return string
     */
    public function parseInput()
    {
        $this->attributes();

        $this->input = '<input ' . implode(' ', $this->attributes) . ' />';
        $this->input .= '<a class="clear-input" data-id="'.$this->elemid.'"><span class="glyphicon glyphicon-refresh"></span></a>';
        return $this->input;
    }

}
