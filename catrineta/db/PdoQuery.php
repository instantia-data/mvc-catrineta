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

namespace Catrineta\db;

use \Catrineta\register\CatExceptions;
use \Catrineta\db\mysql\ConnMysql;
use \Catrineta\register\Monitor;
use \PDOException;
use \PDOStatement;
use \PDO;

/**
 * Description of PdoQuery
 *
 * @author Luís Pinto / luis.nestesitio@gmail.com
 * Created @Sep 30, 2017
 */
class PdoQuery
{

    /**
     *
     * @var \PDO 
     */
    protected $pdo;
    
    /**
     *
     * @var PDOStatement 
     */
    protected $pdostmt;

    /**
     * 
     */
    function __construct()
    {
        $this->pdo = ConnMysql::getConn();
    }
    
    /**
     * 
     * @return \Catrineta\db\PdoQuery
     */
    public static function boot()
    {
        $pdo = new PdoQuery();
        return $pdo;
    }
    
    private $params = [];
    
    /**
     * 
     * @param array $params
     */
    public function setParams($params)
    {
        $this->params = $params;
    }
    
    private $query;
    
    public function setStatementQuery($query)
    {
        $this->query = $query;
    }
    
    private $query_time = 0;
    
    public $numrows = 0;
    
    public $lastid = 0;
    
    /**
     * 
     * @param string $query
     * @return array Containing all of the result set rows
     * @throws CatExceptions
     */
    public function executeQuery()
    {
        $start_time = microtime(true);
        $this->pdostmt = $this->pdo->prepare($this->query);
        $this->bindParams();
        
        if ($this->pdostmt->execute() == false) {
            $this->writeQueryMessage($this->pdostmt->errorInfo()[2]);
            throw new CatExceptions('Query fatal error nº'.$this->pdostmt->errorCode(), CatExceptions::CODE_SQL);
        }
        $this->query_time = number_format(microtime(true) - $start_time, 9);
        
        
    }
    
    

    /**
     * Binds values to a parameters
     * with PDOStatement::bindValue
     */
    protected function bindValues()
    {
        foreach ($this->params as $field => $value) {
            //$value = utf8_decode($value);

            $res = $this->pdostmt->bindValue(':' . $field, $value);
            if($res == false){
                Monitor::add(Monitor::PDO, 'Error binding :' . $field . ' => ' . $value);
            }
        }
    }
    
    /**
     * 
     * @param PDOStatement::errorCode $error
     * @return string
     */
    public function writeQueryMessage($error = null)
    {
        $query = $this->query;
        
        if (is_array($this->params)) {
            foreach ($this->params as $key => $value) {
                $query = str_replace(':' . $key, "'" . $value . "'", $query);
            }
        }
        
        $str = $query;
        if($error == null){
            $str .= '<br /><i>Query took ' . $this->query_time . ' sec</i> for ' . $this->numrows . ' results';
        }else{
            $str .= '<br />' . $this->pdostmt->errorInfo()[2];
        }
        Monitor::add(Monitor::QUERY, $str);
        
        return $str; 
        
    }
    
    /**
     * 
     * @return int The ID of the last inserted row or sequence value
     * @throws CatExceptions
     */
    public function insert($autoincrement = null)
    {
        
        $this->pdostmt = $this->pdo->prepare($this->query);
        
        try {
            $this->pdo->beginTransaction();
            $this->bindValues();
            $this->pdostmt->execute();
            $id = ($autoincrement == null)? null :$this->pdo->lastInsertId();
            $this->numrows = $this->pdo->commit(); 
            $this->writeQueryMessage();
            return ($autoincrement == null)? $this->numrows : $id;
        } catch (PDOException $err) {
            throw new CatExceptions($err, CatExceptions::CODE_SQL);
        }
    }
    
    public function update()
    {
        $this->pdostmt = $this->pdo->prepare($this->query);

        try {
            $this->bindValues();
            $this->pdostmt->execute();
            $this->numrows = $this->pdostmt->rowCount(); 
            $this->writeQueryMessage();
            return $this->numrows;
        } catch (PDOException $err) {
            throw new CatExceptions($err, CatExceptions::CODE_SQL);
        }
    }

    public function select($query)
    {
        $this->query = $query;
        $this->pdostmt = $this->pdo->prepare($this->query);
        $this->bindValues();
        $this->pdostmt->execute();
        $result = $this->pdostmt->fetchAll(PDO::FETCH_ASSOC);
        $this->numrows = count($result);
        
        $this->writeQueryMessage();
        
        return $result;
    }
    

    /**
     * 
     * @return bool <b>TRUE</b> on success or <b>FALSE</b> on failure.
     * @throws CatExceptions
     */
    public function delete()
    {
        //log statement
        $this->writeQueryMessage();
        
        try {
            $this->bindValues();
            $result = $this->pdostmt->execute();
        } catch (PDOException $err) {
            throw new CatExceptions($err, CatExceptions::CODE_SQL);
        }
        //return boolean
        return $result;
    }
    

    
    
    

}
