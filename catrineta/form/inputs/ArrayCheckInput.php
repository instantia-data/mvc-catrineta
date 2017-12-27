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
 * Description of ArrayCheckInput
 *
 * @author Luís Pinto / luis.nestesitio@gmail.com
 * Created @Aug 26, 2015
 */
class ArrayCheckInput extends \Catrineta\form\Input
{
    /**
     * @var array
     */
    private $list = [];

    /**
     * @param String $field The db table field name for reerence to input
     * @return ArrayCheckInput
     */
    public static function create($field = null)
    {
        $obj = new ArrayCheckInput($field, $field);
        return $obj;
    }

    /**
     * @param array $values
     * @return $this
     */
    public function setValuesList($values = [], $serial = false)
    {
        $this->list = $values;
        $this->serial = $serial;
        return $this;
    }
    
    private $serial = false;

    /**
     * @return string
     */
    public function parseInput()
    {
        $this->attributes();
        /*' <input type="checkbox" name="vehicle" value="Bike">I have a bike<br> '*/
        $this->input = '<fieldset id="' . $this->elemid . '">';
        if(isset($this->attributes['required'])){
            $this->input = '<fieldset id="' . $this->elemid . '" required>';
        }
        $selecteds = explode('&&', $this->value);
        $i = 0;
        foreach($this->list as $value => $label){
            $name = ($this->serial == false)? $this->name : $value;
            $this->input .= '<label for ="' . $this->elemid . '_' . ++$i . '">';
            $this->input .= '<input type="checkbox"'
                    . ' name="' . $name . '"  id="' . $this->elemid . '_' . ++$i . '"'
                    . ' value="' . $value . '"';
            if (in_array($value, $selecteds)) {
                $this->input .= ' checked';
            }
            $this->input .= ' /> ' . $label . '</label>&nbsp;';
        }

        $this->input .= '<a class="clear-input" data-id="'.$this->elemid.'"><span class="glyphicon glyphicon-refresh"></span></a>';
        return $this->input;
    }

}
