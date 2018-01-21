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
 * Description of CheckInput
 *
 * @author Luís Pinto / luis.nestesitio@gmail.com
 * Created @May 11, 2015
 */
class BooleanInput extends \Catrineta\form\Input
{
    /**
     * @param String $field The db table field name for reerence to input
     * @return BooleanInput
     */
    public static function create($field = null)
    {
        $obj = new BooleanInput($field, $field);
        $obj->setInputType(Input::TYPE_CHECKBOX);
        return $obj;
    }

    /**
     * @param $label
     * @return string
     */
    public function parseInput($label = '')
    {
        $this->class = '';
        $this->attributes();
        unset($this->attributes['value']);

        $checked = ($this->value == 1)? 'checked="checked"' : '';
        $this->input = '<label>';
        $this->input .= '<input ' . $checked . implode(' ', $this->attributes) . '> ' . $label;
        $this->input .= '</label>';
        return $this->input;
    }

}
