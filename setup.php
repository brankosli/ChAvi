<?php

namespace chAvio;
require_once "vendor/autoload.php";

$type = !empty($_GET['type']) ? $_GET['type'] : 'mysql';

// Db Connection
$dbConfig = require_once('config/db.php'); //- the most simple, can also be extended for different ENV
$database = new Model\Database(
    $dbConfig['host'], $dbConfig['dbName'], $dbConfig['username'], $dbConfig['password'], $dbConfig['options'], $type
);

$db = $database->getConnection();

$setup = new Model\Setup($db);

$setup->createDb($type);

$setup->insertData();

