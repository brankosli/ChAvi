<?php

namespace chAvio\Controllers;

use chAvio\Exceptions\ValidationException;
use chAvio\Model\User;
use chAvio\Model\Validator;

final class UsersController extends Controller
{
	/**
	 * @var \chAvio\Model\Database
	 */
	protected $db;
	
	
	public function __construct($request)
	{
		parent::__construct($request);
		
		// Inject Db Connection
		global $db;
		$this->db = $db->getConnection();
	}
	
	protected function getAction()
	{
		# Input
		$params = $this->getParams() ?? array();

		# Get Data
		$usersModel = new User($this->db);
		$usersModel->setId( $params['id'] ?? null );

		$validator = new Validator($usersModel);

        if(! $validator->validateUser())
        {
            $e = new ValidationException("Bad Data");
            $e->setValidationErrors($validator->errors());
            throw $e;
        }

		$data = $usersModel->getSingleUser();
		
		# Response
		$responseCode = 200;
		$response = array(
			'Message' => "This is {$data['name']}, born in {$data['yearOfBirth']}.",
			'Data' => $data
		);
		$this->response($responseCode,$response);
	}
	
	protected function insertAction()
	{
		# Input
		$params = $this->getParams() ?? array();
		
		$usersModel = new User($this->db);
		$usersModel->setName( $params['name'] ?? null );
		$usersModel->setYearOfBirth( $params['year_of_birth'] ?? null );
		$usersModel->setCreated();

        $validator = new Validator($usersModel);

        if(! $validator->validateCreateUser())
        {
            $e = new ValidationException("Bad Data");
            $e->setValidationErrors($validator->errors());
            throw $e;
        }

		$newUserId = $usersModel->createUser();
		
		# Respond
		$responseCode = 201;
		$response = array(
			'Message' => "New user with id {$newUserId} has been created.",
			'Data' => array(
				'id' => $newUserId
			)
		);
		$this->response($responseCode,$response);
	}
	
	protected function updateAction()
	{
		# Input
		$params = $this->getParams() ?? array();
		
		$usersModel = new User($this->db);
		$usersModel->setId( $params['id'] ?? null );
        $usersModel->setName( $params['name'] ?? null );
        $usersModel->setYearOfBirth( $params['year_of_birth'] ?? null );
        $usersModel->setUpdated();

        $validator = new Validator($usersModel);

        if(! $validator->validateUpdateUser())
        {
            $e = new ValidationException("Bad Data");
            $e->setValidationErrors($validator->errors());
            throw $e;
        }

		$responseCode = 200;
		$response = array(
			'Message' => 'User has been updated!',
			'Data' => array()
		);
		$this->response($responseCode,$response);
	}
	
	protected function deleteAction()
	{
		$params = $this->getParams() ?? array();

		$usersModel = new User($this->db);
        $usersModel->setId( $params['id'] ?? null );

        $validator = new Validator($usersModel);

        if(! $validator->validateUser())
        {
            $e = new ValidationException("Bad Data");
            $e->setValidationErrors($validator->errors());
            throw $e;
        }

        $usersModel->deleteUser();

		$responseCode = 200;
		$response = array(
			'Message' => 'Delete User ID '.$params['id'].' successful.',
			'Data' => array()
		);
		$this->response($responseCode,$response);
	}
	
	
}