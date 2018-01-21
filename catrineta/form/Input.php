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

namespace Catrineta\form;

use \Catrineta\register\Monitor;

/**
 * Description of Input
 *
 * @author Luís Pinto / luis.nestesitio@gmail.com
 * Created @Dec 7, 2017
 */
class Input
{

    /**
     *
     */
    const TYPE_SELECT = 'select';
    /**
     *
     */
    const TYPE_HIDDEN = 'hidden';
    /**
     *
     */
    const TYPE_TEXT = 'text';
    /**
     *
     */
    const TYPE_CHECKBOX = 'checkbox';
    /**
     *
     */
    const TYPE_FILE = 'file';

    /**
     *
     */
    const ADDON_L = 'L';
    /**
     *
     */
    const ADDON_R = 'R';

    /**
     * @var
     */
    protected $input;
    /**
     * @var array
     */
    protected $attributes = [];

    /**
     * @var string
     */
    protected $type = self::TYPE_TEXT;
    /**
     * @var null
     */
    protected $name = null;
    /**
     * @var null
     */
    protected $elemid = null;

    /**
     * @var null
     */
    protected $value = null;
    /**
     * @var null
     */
    protected $default = null;

    /**
     * @var null
     */
    protected $placeholder = null;
    /**
     * @var string
     */
    protected $disabledvalue = '';
    /**
     * @var string
     */
    protected $class = 'form-control';

    /**
     * @var string
     */
    protected $addon_l = '';
    /**
     * @var string
     */
    protected $addon_r = '';

    /**
     * @var bool
     */
    protected $required = false;
    /**
     * @var null
     */
    protected $range = null;


    /**
     * Input constructor.
     * @param String $name The name for the input
     * @param String $elemid The id for the input
     */
    public function __construct($name = null, $elemid = null)
    {
        self::setElementId($name, $elemid);
    }

    /**
     *
     */
    public function __clone() {}

    /**
     * Set id and name for the input
     *
     * @param String $name The name for the input
     * @param String $elemid The id for the input
     */
    public function setElementId($name = null, $elemid = null)
    {
        if(null != $name){
            $this->name = $name;
        }
        if(null != $name && null == $elemid){
            $this->elemid = $name;
        }
        if(null != $elemid){
            $this->elemid = $elemid;
        }
    }

    /**
     * @return $this
     */
    public function emptyValue()
    {
        $this->setValue();
        $type = $this->getInputType();
        if($type == self::TYPE_SELECT){
            $this->addEmpty();
        }
        return $this;
    }

    /**
     * @return bool
     */
    public function isMultiple()
    {
        return (isset($this->attributes['multiple']))? true : false;
    }

    /**
     * @return $this
     */
    public function setMultiple()
    {
        return $this;
    }

    /**
     * @param string $value
     * @return $this
     */
    public function setValue($value = '')
    {
        $this->value = $value;
        if($this->disabledvalue == ''){
            $this->disabledvalue = $value;
        }
        if(!empty($value)){
            Monitor::add(Monitor::FORM, 'Set value for ' . $this->name . ' = ' .
                    (is_array($value))? $value: 'Array: ' . implode("&",$value));
        }
        return $this;
    }

    /**
     * @param $values
     * @return $this
     */
    public function setArray($values)
    {
        $this->value = implode('&&', $values);
        Monitor::add(Monitor::FORM, 'Set value for ' . $this->name . ' = ' . implode('&&', $values));
        return $this;
    }

    /**
     * @return null
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * @return null
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return null
     */
    public function getId()
    {
        return $this->elemid;
    }

    /**
     * @param $value
     * @return $this
     */
    public function setName($value)
    {
        $this->name = $value;
        return $this;
    }

    /**
     * @param $value
     * @return $this
     */
    public function setId($value)
    {
        $this->elemid = $value;
        return $this;
    }


    /**
     * @param $value
     * @return $this
     */
    public function setDefault($value)
    {
        if(null == $this->value){
            $this->value = $value;
            $this->default = $value;
            Monitor::add(Monitor::FORM, 'Set default value for ' . $this->name . ' = ' . $value);
        }
        return $this;
    }


    /**
     * @param $bool
     * @param bool $force
     * @return $this
     */
    public function setRequired($bool, $force = false)
    {
        if($force == true){
            $this->required = true;
        }
        if($bool == true){
            $this->attributes['required'] = 'required';
        }elseif($this->required == false && $bool == false && isset($this->attributes['required'])){
            unset($this->attributes['required']);
        }
        return $this;
    }


    /**
     * @param $type
     */
    public function setInputType($type)
    {
        $this->type=$type;
    }

    /**
     * @return string
     */
    public function getInputType()
    {
        return $this->type;
    }

    /**
     * @param $placeholder
     */
    public function setPlaceHolder($placeholder)
    {
        $this->placeholder=$placeholder;
    }

    /**
     * @return mixed
     */
    public function getInput()
    {
        return $this->input;
    }

    /**
     * @param $length
     * @return $this
     */
    public function setMaxlength($length)
    {
        $this->attributes['maxlength'] = 'maxlength="' . $length . '"';
        return $this;
    }

    /**
     * @param $attribute
     * @param $value
     * @return $this
     */
    public function setDataAttribute($attribute, $value)
    {
        $this->attributes[$attribute] = $attribute . '="' . $value . '"';
        return $this;
    }
    
    /**
     * 
     * @param string $function The name of javascript function
     * @return \lib\form\Input
     */
    public function setDataFunction($function)
    {
        $this->setDataAttribute('data-function', $function);
        return $this;
    }
    


    /**
     *
     */
    protected function attributes()
    {
        $this->elemid = str_replace('.', '_', $this->elemid);
        $this->name = str_replace('.', '_', $this->name);
        $this->attributes['type'] = 'type="' . $this->type . '"';
        $this->attributes['name'] = 'name="' . $this->name . '"';
        $this->attributes['id'] = 'id="' . $this->elemid . '"';
        $this->attributes['value'] = 'value="' . $this->value . '"';
        $this->attributes['class'] = 'class="' . $this->class . '"';
        if (null != $this->placeholder) {
            $this->attributes['placeholder'] = 'placeholder="' . $this->placeholder . '"';
        }
    }

    /**
     * @param $char
     * @param $class
     * @return string
     */
    protected function buildAddon($char, $class)
    {
        return '<span class="' . $class . '">' . $char . '</span>';
    }

    /**
     * @param $char
     * @param string $pos
     * @return $this
     */
    public function setAddon($char, $pos = self::ADDON_L)
    {
        if($pos == self::ADDON_R){
            $this->addon_r = $this->buildAddon($char, 'input-addon addon-right');
            $this->class .= ' with-add-right';
        }else{
            $this->addon_l = $this->buildAddon($char, 'input-addon addon-left');
            $this->class .= ' with-add-left';
        }
        return $this;
    }

    /**
     * @param $class
     */
    public function addClass($class)
    {
        $this->class .= ' ' . $class;
        return $this;
    }

    /**
     * @param $range
     */
    public function setRange($range)
    {
        $this->range = $range;
    }

    /**
     * @return null
     */
    public function getRange()
    {
        return $this->range;
    }
    
    public function getPostKey(){
        return \lib\form\form\FormValidator::correctKey($this->getName());
    }
    
    public function getPostedValue($filter = FILTER_SANITIZE_SPECIAL_CHARS) {
        $value = filter_input(INPUT_POST, $this->getPostKey(), $filter);
        //$value = strip_tags($value, $allowable_tags);
        return $value;
    }

}
