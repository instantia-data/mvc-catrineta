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
 * Description of ArrayRadioInput
 *
 * @author Luís Pinto / luis.nestesitio@gmail.com
 * Created @Mar 1, 2016
 */
class ArrayRadioInput extends \Catrineta\form\Input
{
    /**
     * @var array
     */
    private $list = [];

    /**
     * @param String $field The db table field name for reerence to input
     * @return ArrayRadioInput
     */
    public static function create($field = null)
    {
        $obj = new ArrayRadioInput($field, $field);
        return $obj;
    }

    /**
     * @param array $values
     * @return $this
     */
    public function setValuesList($values = [])
    {
        $this->list = $values;
        return $this;
    }

    /**
     * @return string
     */
    public function parseInput()
    {
        $this->attributes();
        /* ' <div class="radio-inline">
          <label><input type="radio" name="optradio">Option 1</label>
          </div> ' */
        $this->input = '<fieldset id="' . $this->elemid . '">';
        if(isset($this->attributes['required'])){
            $this->input = '<fieldset id="' . $this->elemid . '" required>';
        }
        $selecteds = explode('&&', $this->value);
        $i = 0;
        foreach($this->list as $value => $label){
            $this->input .= '<input type="radio"'
                    . ' name="' . $this->name . '"  id="' . $this->elemid . '_' . ++$i . '"'
                    . ' value="' . $value . '"';
            if (in_array($value, $selecteds)) {
                $this->input .= ' checked';
            }
            $this->input .= ' /> ' . $label . '&nbsp;';
        }

        $this->input .= '<a class="clear-input" data-id="'.$this->elemid.'"><span class="glyphicon glyphicon-refresh"></span></a>';
        return $this->input;
    }

}
