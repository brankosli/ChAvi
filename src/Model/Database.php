<?php

namespace chAvio\Model;

use \PDO;
use \PDOException;
use chAvio\Exceptions\DbException;

class Database {

    /**
     *
     */
    const PATH_TO_SQLITE_FILE = 'db/phpsqlite.db';

    /**
     * @var string
     */
    private $host;

    /**
     * @var integer
     */
    private $port;

    /**
     * @var string
     */
    private $dbName;

    /**
     * @var string
     */
    private $username;

    /**
     * @var string
     */
    private $password;

    /**
     * @var string
     */
    private $pdoType;

    /**
     * @var array
     */
    private $options;

    /**
     * @var PDO|null
     */
    public $connection;

    /**
     * Database constructor.
     *
     * @param string $host
     * @param string $dbName
     * @param string $username
     * @param string $password
     * @param array $options
     * @param int $port
     * @param string $pdoType
     * @throws DbException
     */
    public function __construct($host, $dbName, $username, $password, $options = array(), $pdoType = 'mysql', $port=3306 )
    {
        $this->host = $host;
        $this->dbName = $dbName;
        $this->username = $username;
        $this->password = $password;
        $this->options = $options;
        $this->port = $port;
        $this->pdoType = $pdoType;

        $this->connection = null;

        try{
            if($pdoType == 'mysql') {
                $dsn = "mysql:host=" . $this->host . "; port=" . $this->port . "; dbname=" . $this->dbName;
                $connection = new PDO($dsn, $this->username, $this->password);
                if(!empty($this->options['utf8'])) $connection->exec("set names utf8");
                $this->connection = $connection;
            }

            if($pdoType == 'sqlite') {
                new PDO("sqlite:" . Config::PATH_TO_SQLITE_FILE);
            }

        } catch(PDOException $exception){
            throw new DbException("DB Connection failed.",0,$exception);
        }
    }

    /**
     * Get Database Connection
     *
     * @return PDO|null
     */
    public function getConnection()
    {
        return $this->connection;
    }

    /**
     * @return Database
     */
    public static function getInstance()
    {
        if(!self::$instance)
        {
            self::$instance = new Database();
        }

        return self::$instance;
    }

}