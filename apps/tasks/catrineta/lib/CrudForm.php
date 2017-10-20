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

namespace Tasks\catrineta\lib;

use \Catrineta\console\crud\ParseLoop;
use \Catrineta\console\crud\CrudTools;
use \Catrineta\orm\ModelTools;


/**
 * Description of CrudForm
 *
 * @author Luís Pinto / luis.nestesitio@gmail.com
 * Created @Sep 16, 2017
 */
class CrudForm extends \Catrineta\console\crud\ModelCrud
{


    
    public function parseLoops()
    {
        $parse = new ParseLoop($this->string);
        foreach($this->columns as $field){
            if($field['Default'] == 'CURRENT_TIMESTAMP' || $field['Comment'] == 'ignore'){
                continue;
            }
            $this->makeDeclare($parse, $field);
            $this->makeValidate($parse, $field);
            if(isset($this->constrains[$field['Field']])){
                $this->makeMuls($parse, $field, 'mul', $this->constrains[$field['Field']]);
            } elseif ($field['Kind'] == 'set' || $field['Kind'] == 'enum') {
                $this->makeMuls($parse, $field, 'set');
            } else {
                $this->makeMethod($parse, $field);
            }
            
            
        }
        
        file_put_contents($this->file, $parse->parseWhile());
    }
    
    private function makeDeclare(ParseLoop $parse, $field)
    {
        $parse->setData('declares', [
            'method'=>ModelTools::buildModelName($field['Field'])
        ]);
    }
    
    private function makeValidate(ParseLoop $parse, $field)
    {
        $parse->setData('validates', [
            'method'=>ModelTools::buildModelName($field['Field'])
        ]);
    }
    
    private function makeMethod(ParseLoop $parse, $field)
    {
        $array = $this->writeMethods($field);
        $parse->setData('columns', [
            'method' => ModelTools::buildModelName($field['Field']),
            'table' => $this->classname . '::TABLE',
            'field' => $this->classname . '::' . ModelTools::getFieldConstant($this->table, $field['Field']),
            'inputMethod' => $array['input'], 'getval'=>$array['getval'], 'extension'=>$array['extension']
            
        ]);
    }
    
    private function makeMuls(ParseLoop $parse, $field, $type, $constrain = null)
    {
        /*
         * {$item.extension}
         * ->setModel(\Model\querys\{$item.model}Query::start())->setOptionIndex({$item.index})->addEmpty()
         * ->setValuesList({$item.values})
         */
        $default = 'null';
        if($field['Default'] != null){
            $default = "'" . $field['Default']. "'";
        }
        if($type == 'set'){
            $extension = '->setValuesList(\\Model\\models\\' . $this->classname . '::$' . $field['Field'] . 's)';
        }else{
            $model = '\Model\querys\\' . ModelTools::buildModelName($constrain['REFERENCED_TABLE_NAME']);
            $index = '\\Model\\models\\' . ModelTools::buildModelName($constrain['REFERENCED_TABLE_NAME']). '::' . 
                    CrudTools::writeFieldConstantName($constrain['REFERENCED_TABLE_NAME'], $constrain['REFERENCED_COLUMN_NAME']);
            echo "CONSTRAINT: " . $constrain['REFERENCED_TABLE_NAME'] . '|' 
                    . $constrain['REFERENCED_COLUMN_NAME']. " | " . $index . "\n";

            $extension = '->setModel('.$model.'Query::start())'."\n\t\t".'->setOptionIndex('.$index.')->addEmpty()';
        }
        $parse->setData('selects', [
            'method' => ModelTools::buildModelName($field['Field']),
            'table' => $this->classname . '::TABLE',
            'field' => $this->classname . '::' . ModelTools::getFieldConstant($this->table, $field['Field']),
            'inputMethod' => 'SelectInput',
            'default'=>$default,
            'extension'=>$extension
            
        ]);
    }
    
    
    private function writeMethods($field)
    {
        $array = ['method'=>'', 'input'=>'InputText', 'extension'=>'', 'getval'=>'Value'];
        if ($field['Key'] == 'PRI'){
            $array = $this->arrayForPrimary($array, $field);
        } elseif ($field['Kind'] == 'datetime') {
            $array['input'] = 'DateInput';
            $array['method'] = 'Date';
            $array['extension'] = '->setTimestamp('.$field['Type'].')';
            $array['getval'] = 'Date';
        } elseif ($field['Kind'] == 'text' || $field['Kind'] == 'tinytext') {
            $array['input'] = 'TextAreaInput';
            $array['method'] = 'Text';
        } elseif ($field['Kind'] == 'tinyint') {
            $array['input'] = 'BooleanInput';
            $array['method'] = 'Bool';
        } else {
            $array = $this->writeVarcharInput($array, $field);
        }
        
        return $array;
    }
    
    
    private function arrayForPrimary($array, $field)
    {
        $array['input'] = 'HiddenInput';
        $array['method'] = 'PrimaryKey';
        $array['args'] = '\\Model\\querys\\' . ModelTools::buildModelName($this->table) . 'Query::start()';
        if($field['Kind'] == 'varchar'){
            $array['input'] = 'InputText';
        }
        
        return $array;
    }
    

    
    private function writeVarcharInput($array, $field)
    {
        $array['input'] = 'InputText';
        
        if($field['Null'] == 'NO'){
            $array['extension'] .= '->setRequired(true)';
        }
        if($field['Default'] != null){
            $array['extension'] .= "->setDefault('" . $field['Default'] . "')";
        }
        
        $lenght = 0;

        if ($field['Kind'] == 'int') {
            $lenght = str_replace(['int(', ')'], ['', ''], $field['Type']);
            $array['extension'] .= "->setMaxlength('$lenght')";
            $array['method'] = 'Int';

        } elseif ($field['Kind'] == 'decimal'  || $field['Kind'] == 'float') {
            $numeric = str_replace(['decimal(','float(',')'], [''], $field['Type']);
            $lenght = intval($numeric) + floatval($numeric) + 1;
            $array['extension'] .= "->setMaxlength('$lenght')";
            $array['method'] = 'Float';
        }else{
            $lenght = str_replace(['varchar(', ')'], ['', ''], $field['Type']);
            $array['extension'] .= "->setMaxlength('$lenght')";
            $array['method'] = 'String';
        }
        return $array;
    }
    

}
