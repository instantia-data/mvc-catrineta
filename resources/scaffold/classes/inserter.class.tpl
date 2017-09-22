<?php

/*
 * Copyright (C) %year% %author%
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

namespace Apps\after;


/**
 * Description of %className%Inserter
 *
 * @author %author%
 * Created @%dateCreatedd%
 * Updated @%dateCreatedd% *
 */
class %className%Inserter extends \Catrineta\framework\InserterApp {

    /**
     * launch this inserter
     */
    public static function run(){
        $job = new %className%Inserter();
        $job->compose();
        
    }
    
    /**
     * add tags to template
     * $this->add('tag', 'value');
     */
    public function compose(){
        $this->add('hello', 'Hello!');
    }

}

