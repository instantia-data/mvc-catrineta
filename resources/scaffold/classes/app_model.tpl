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
 
namespace Apps\%$nameApp%\model;

use \Model\querys\%$modelName%Query;

/**
 * Description of %$className%UtilQueries
 *
 * @author Luís Pinto / luis.nestesitio@gmail.com
 * Created @%$dateCreated%
 * Updated @%$dateUpdated% *
 */
class %$className%UtilQueries {

    /**
    * Create and return the common query to this class
    *
    * @return \Model\querys\%$modelName%Query;
    */
    public static function get%$className%(){
        $query = %$modelName%Query::init(){@while ($item in joins):}
        ->join{$item.tableJoin}(){$item.selects}->endUse(){@endwhile;};
        
        return $query;
    }

    

}
