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

route_group(['prefix' => 'user'], function () {
    route_get('change', 'UserController@showChangeForm');
    route_post('password', 'UserController@changePassword');
});

route_group(['prefix' => 'user'], function () {
    route_get('/', 'Lib/User@index');
    route_get('edit/{id:d}', 'Lib/User@edit');
});

route_group(['prefix' => 'admin', 'filter'=> 'AdminAuth'], function () {
    route_group(['prefix' => 'user'], function () {
        route_get('/', 'Admin/User@index');
        route_get('edit/{id:d}', 'Admin/User@edit');
    });
    
    route_group(['prefix' => 'pages'], function () {
        route_get('/', 'Admin/Pages@index');
        route_get('edit/{id:d}', 'Admin/Pages@edit');
    });
});

route_group(['prefix' => 'news'], function () {
    route_get('/', 'News/Articles@index');
    route_get('edit/{id:d}', 'News/Articles@index');
    route_get('{title:htm}', 'News/Articles@article');
});

route_get('/', 'Main/Home@index')->name('home');

route_get('error', 'Main/Error@index')->name('error');


