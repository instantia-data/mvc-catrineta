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
 * Description of FileInput
 *
 * @author Luís Pinto / luis.nestesitio@gmail.com
 * Created @Jun 16, 2016
 */
class FileInput extends \Catrineta\form\Input {

    protected $type = self::TYPE_FILE;
    
    protected $url = '';
    
    private $allowed = [];

    /**
     * 
     * @param string $field
     * @return \lib\form\input\FileInput
     */
    public static function create($field = null)
    {
        $obj = new FileInput($field, $field);
        $obj->setAllowed(['png', 'jpg']);
        return $obj;
    }
    
    public function setuploadUrl($url){
        $this->url = $url;
        return $this;
    }
    
    public function setAllowed($extensions = []){
        $this->allowed = $extensions;
        return $this;
    }
    
    private $filetype = 'image';
    
    public function setFileType($type){
        $this->filetype = $type;
        return $this;
    }
    
    public function parseInput(){
        /*
         * <input id="input-700" name="kartik-input-700[]" type="file" multiple class="file-loading">
         */
        $this->attributes();
        
        $this->attributes['class'] = 'class="' . $this->class . ' file-input"';
        $this->attributes['value'] = 'value="' . $this->value . '"';
        $this->attributes['data-file'] = 'data-file="' . $this->filetype . '"';
        $this->attributes['data-url'] = 'data-url="'.$this->url.'&default=' . $this->value . '"';
        $this->attributes['data-allowed'] = 'data-allowed="'. implode(',', $this->allowed) . '"';
        //data-allowed-file-extensions='["csv", "txt"]'

        $this->input = '<input '.implode(' ', $this->attributes).'>';
        return $this->input;
    }

}
