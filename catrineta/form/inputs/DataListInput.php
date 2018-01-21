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
 * Description of DataListInput
 *
 * @author Luís Pinto / luis.nestesitio@gmail.com
 * Created @Mar 19, 2015
 */
class DataListInput extends \lib\form\input\SelectInput
{
    /**
     * @param String $field The db table field name for reerence to input
     * @return DataListInput
     */
    public static function create($field = null)
    {
        $obj = new DataListInput($field, $field);
        return $obj;
    }

    /**
     * @return string
     */
    public function parseDataListInput()
    {
        if($this->model !=  null){
            $this->parseModel();
        }
        $this->attributes();
        $idlist = $this->elemid . '_list';
        $datalist = '';

        if (isset($this->options)) {
            $datalist .= '<datalist id="' . $idlist . '">';
            foreach ($this->options as $key => $value) {
                $datalist .= '<option value="' . $value . '">';
                if($key == $this->value){
                    $this->value = $value;
                }
            }
            $datalist .= '</datalist>';
        }
        $this->attributes['value'] = 'value="' . $this->value . '"';
        $this->input = '<input list="' . $idlist . '" ' . implode(' ', $this->attributes) . ' />';
        $this->input .= $datalist;
        $this->input .= '<a class="clear-input" data-id="'.$this->elemid.'"><span class="glyphicon glyphicon-refresh"></span></a>';
        return $this->input;
    }

    /**
     * @return string
     */
    public function parseInput()
    {
        return $this->parseDataListInput();
    }



}
