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
 * Description of InputInfo
 *
 * @author Luís Pinto / luis.nestesitio@gmail.com
 * Created @Oct 5, 2015
 */
class InputInfo extends \Catrineta\form\Input
{
    /**
     * @var null
     */
    private $selectedcolumn = null;
    /**
     * @var null
     */
    private $model = null;
    /**
     * @var null
     */
    private $description = null;

    /**
     * @param String $field The db table field name for reerence to input
     * @return InputInfo
     */
    public static function create($field = null)
    {
        $obj = new InputInfo($field, $field);
        $obj->setInputType(Input::TYPE_TEXT);
        return $obj;
    }


    /**
     * @param $model
     * @param $selectedcolumn
     */
    public function setModel($model, $selectedcolumn)
    {
        unset($this->options);
        $this->model = $model;
        $this->selectedcolumn = $selectedcolumn;
        //asort($this->options);

    }

    /**
     * @param array $columns
     */
    public function setColumnsDescription($columns = [])
    {
        $this->description = $columns;
    }

    /**
     * @return string
     */
    private function parseModel()
    {
        if ($this->description != null) {
            foreach (array_keys($this->description) as $col) {
                $this->model->setSelect($col);
            }
        }
        $result = $this->model->filterByColumn($this->selectedcolumn, $this->value)->findOne();
        if ($this->description == null) {
            return (string) $result;
        } else {
            $string = '';
            foreach ($this->description as $col => $glue) {
                $string .= $glue . $result->getColumnValue($col);
            }
            return $string;
        }
    }

    /**
     * @var array
     */
    private $convertedvalues = [];

    /**
     * @param $file
     */
    public function convertValuesByXml($file)
    {
        if(!empty($file)){
            $this->convertedvalues = \lib\xml\XmlSimple::getConvertedList($file);
        }
    }

    /**
     * @return string
     */
    public function parseInput()
    {
        $this->attributes();
        //<input type="text" name="country" value="Norway" readonly>

        $value = ($this->model !=  null)? $this->parseModel() : $this->value;
        if(isset($this->convertedvalues[$value])){
            $value = $this->convertedvalues[$value];
        }

        $this->input = '<input ' . $this->attributes['class'] . ' value="' . $value . '" readonly>';
        unset($this->attributes['class']);
        unset($this->attributes['type']);
        $this->input .= '<input type="' . Input::TYPE_HIDDEN . '" ' . implode(' ', $this->attributes) . '>';
        return $this->input;
    }

}
