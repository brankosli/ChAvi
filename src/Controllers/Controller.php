<?php


namespace chAvio\Controllers;

use chAvio\Exceptions\RouteException;


abstract class Controller
{
	/**
	 * @var array
	 */
	protected $request;
	
	/**
	 * Controller constructor.
	 * @param array $request
	 */
	public function __construct($request)
	{
		$this->request = $request;
	}
	
	/**
	 * @throws RouteException
	 */
	public function dispatch()
	{
		$requestMethod = $this->getRequestMethod();
		switch($requestMethod){
			case 'GET':
				$this->getAction();
				break;
			
			case 'POST':
				$this->insertAction();
				break;
			
			case 'PUT':
				$this->updateAction();
				break;
			
			case 'DELETE':
				$this->deleteAction();
				break;
			
			default:
				throw new RouteException("Unsupported request method.");
		}
	}
	
	/**
	 * @return string|null Returns request method: GET, POST, PUT, DELETE
	 */
	public function getRequestMethod()
	{
		return ($this->request['REQUEST_METHOD'] ?? null);
	}
	
	/**
	 * @return mixed
	 */
	public function getParams()
	{
		$requestMethod = $this->getRequestMethod();

		switch($requestMethod){
			case 'GET':
				return $_GET;
				break;
			
			case 'POST':
				return $_POST;
				break;
			
			case 'PUT':
				//- TODO: get PUT params
                return $_REQUEST;
				break;
			
			case 'DELETE':
				//- TODO: get DELETE params
                return $_REQUEST;
				break;
		}
	}
	
	/**
	 * @param int $responseCode HTTP response code
	 * @param mixed $response
	 * @param bool $terminate Exit/Terminate app after response
	 */
	protected function response($responseCode,$response,$terminate=true)
	{
		http_response_code($responseCode);
		if( !empty($response) ) echo json_encode($response);
		if( $terminate===true ) exit;
	}
	
	
}