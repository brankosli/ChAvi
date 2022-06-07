<?php

namespace chAvio\Interfaces;

use chAvio\Model\Database;

interface DatabaseInterface
{
    /**
     * @param str $host
     * @param int $port
     * @param str $dbName
     * @param str $username
     * @param str $password
     * @param array $options
     */
    public function __construct($host, $dbName, $username, $password, $options=array(), $port=3306);

    /**
     * @return \PDO
     */
    public function getConnection();

    /**
     * @return Database
     */
    public static function getInstance();

}