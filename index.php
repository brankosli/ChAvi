<?php
// Define App Namespace
namespace chAvio;

// Base (Default) Environment settings
use chAvio\Exceptions\DbException;
use \PDOException;

$regionalConfig = require_once('config/regional.php'); //- the most simple, can also be extended for different ENV
date_default_timezone_set($regionalConfig['timezone']);

$errorConfig = require_once('config/errors.php'); //- the most simple, can also be extended for different ENV
error_reporting($errorConfig['report_level']);
ini_set("display_errors", $errorConfig['display_errors']);

// App Headers
header("Content-Type: application/json; charset=UTF-8"); //- dedicated to REST app and JSON responses;
header("Access-Control-Allow-Origin: *");
header("Allow: GET, POST, PUT, DELETE");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
http_response_code(200); //- default

// Include Composer Autoload
require_once('vendor/autoload.php');

// Wrap Errors/Exceptions for whole app
$request = $_SERVER;


try{
    $type = !empty($_GET['type']) ? $_GET['type'] : 'mysql';

    // Db Connection
	$dbConfig = require_once('config/db.php'); //- the most simple, can also be extended for different ENV
	$db = new Model\Database(
		$dbConfig['host'], $dbConfig['dbName'], $dbConfig['username'], $dbConfig['password'], $dbConfig['options'], $type
	);
	// Users Controller
	$usersController = new Controllers\UsersController($request);
	$usersController->dispatch();
	
	
} catch(Exceptions\DbException $e){
	// DB error
	$responseCode = 500;
	$response = array(
		'Message' => $e->getMessage()
	);
	http_response_code($responseCode);
	if( !empty($response) ) echo json_encode($response);
	exit;
	
} catch(Exceptions\RouteException $e){
	//- Route Error
	$responseCode = 401;
	$response = array(
		'Message' => $e->getMessage()
	);
	http_response_code($responseCode);
	if( !empty($response) ) echo json_encode($response);
	exit;
} catch(Exceptions\ValidationException $e){
    //- Route Error
    $responseCode = 400;
    $response = array(
        'Message' => $e->getMessage(),
        'Errors' => $e->getValidationErrors()
    );
    http_response_code($responseCode);
    if( !empty($response) ) echo json_encode($response);
    exit;
}