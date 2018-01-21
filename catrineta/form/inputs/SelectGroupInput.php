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
 * Description of SelectGroupInput
 *
 * <optgroup label="NFC EAST">
              <option>Dallas Cowboys</option>
              <option>New York Giants</option>
              <option>Philadelphia Eagles</option>
              <option>Washington Redskins</option>
            </optgroup>
 *
 * @author Luís Pinto / luis.nestesitio@gmail.com
 * Created @Feb 24, 2016
 */
class SelectGroupInput extends \lib\form\input\SelectInput
{
    /**
     * @param bool $cleaner
     * @return string
     */
    public function parseInput($cleaner = true)
    {
        $this->attributes['name'] = 'name="' . $this->name . '"';
        $this->attributes['id'] = 'id="' . $this->elemid . '"';
        $this->attributes['class'] = 'class="chosen-select"';
        $this->attributes['placeholder'] = 'placeholder="select"';
        $this->input = $this->addon_l . '<select style="width:' . $this->width . '" '
                . implode(' ', $this->attributes) . '>';

        $optionoriginal = '<option value="#index" selected>#label</option>';
        if($this->empty == true){
           $this->input .= str_replace(['#index', 'selected', '#label'], ['', '',''], $optionoriginal);
        }
        if (isset($this->options)) {
            $this->renderOptions();
        }

        $this->input .= '</select>' . $this->addon_r;
        if($cleaner == true){
            $this->input .= '<a class="clear-input" data-id="'.$this->elemid.'"><span class="glyphicon glyphicon-refresh"></span></a>';
        }

        $this->input .= $this->renderSelects();

        return $this->input;
    }

    /**
     *
     */
    private function renderOptions()
    {
        foreach ($this->options as $key=>$group) {
            $this->input .= '<optgroup label="'.$key.'">';
            foreach($group as $id=>$label){
                $this->input .= '<option id="'.$id.'">'.$label.'</option>';
            }

            $this->input .= '</optgroup>';
        }
    }

    /**
     *
     */
    private function renderSelects()
    {
        //$this->input .= '<br />';
        foreach(array_keys($this->options) as $key){
            $this->input .= '<a data-group="'.$key.'" '
                    . 'data-input="'.$this->elemid.'" class="chosen-select-group">'.$key. '</a> | ';
        }
        $this->input .= '<a data-input="'.$this->elemid.'" class="chosen-select-group">Limpar</a>';
    }

    /**
     * @param $values
     * @return $this
     */
    public function setOptGroup($values)
    {
        $this->options = [];
        foreach($values as $key=>$group){
            foreach($group as $id=>$label){
               $this->options[$key][$id] = $label;
            }

        }

        if($this->empty == true){
            $this->addEmpty();
        }
        return $this;
    }

}
