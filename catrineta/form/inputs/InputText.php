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
 * Description of InputText
 *
 * @author Luís Pinto / luis.nestesitio@gmail.com
 * Created @Dec 5, 2014
 */
class InputText extends \Catrineta\form\Input
{
    /**
     * @var null
     */
    private $disabled = null;

    /**
     * @param String $field The db table field name for reerence to input
     * @return InputText
     */
    public static function create($field = null)
    {
        $obj = new InputText($field, $field);
        return $obj;
    }

    /**
     * @return $this
     */
    public function setDisabled()
    {
        $this->disabled = true;
        return $this;
    }

    /**
     * @param $value
     * @return $this
     */
    public function setDisabledValue($value)
    {
        $this->disabledvalue = $value;
        $this->value = $value;
        return $this;
    }


    /**
     * @return string
     */
    private function parseEnabled()
    {
        $this->attributes();

        $this->input = '<input ' . implode(' ', $this->attributes) . ' />';
        $this->input .= '<a class="clear-input" data-id="'.$this->elemid.'"><span class="glyphicon glyphicon-refresh"></span></a>';
        return $this->input;
    }

    /**
     * @return string
     */
    private function parseDisabled()
    {
        $this->attributes();
        $class = $this->attributes['class'];
        unset($this->attributes['class']);
        $this->input = '<input type="hidden" ' . implode(' ', $this->attributes) . '>';
        unset($this->attributes['type']);
        unset($this->attributes['id']);
        unset($this->attributes['name']);
        unset($this->attributes['value']);
        $this->input .= '<input id="'.$this->name.'_disabled" '
                . $class . ' type="text" ' . implode(' ', $this->attributes)
                . ' value="' . $this->disabledvalue . '" disabled />';

        return $this->input;
    }


    /**
     * @return string
     */
    public function parseInput()
    {
        if($this->disabled == true){
            return $this->addon_l . $this->parseDisabled() . $this->addon_r;
        }else{
            return $this->addon_l . $this->parseEnabled() . $this->addon_r;
        }
    }



}
