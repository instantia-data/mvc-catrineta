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

namespace Catrineta\session;

/**
 * Description of SessionVars
 *
 * @author Luís Pinto / luis.nestesitio@gmail.com
 * Created @Nov 24, 2017
 */
class SessionVars
{

    /**
     * @var
     */
    protected static $id;

    /**
     * @var array
     */
    protected static $sessionFilters = [];

    /**
     * @var array
     */
    protected static $sessionShop = [];

    /**
     * @var array
     */
    protected static $sessionConf = [];
    
    /**
     * 
     */
    const SESS_LANG = 'lang';
    /**
     *
     */
    const SESS_USER = 'user';
    /**
     *
     */
    const SESS_PLAYER = 'player';
    /**
     *
     */
    const SESS_FILTER = 'filters';
    /**
     *
     */
    const SESS_SHOP = 'shop';
    /**
     *
     */
    const SESS_PAGE = 'page';
    /**
     *
     */
    const SESS_WARNING = 'warning';
    /**
     *
     */
    const SESS_INFO = 'info';
    /**
     *
     */
    const SESS_PAGERETURN = 'return';
    /**
     *
     */
    const SESS_CONFIG = 'config';

}
