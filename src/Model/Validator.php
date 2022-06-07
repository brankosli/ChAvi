<?php

namespace chAvio\Model;

use \chAvio\Model\User;

class Validator {

    private $user;

    private $errors = array();

    public function __construct($user)
    {
        $this->user = $user;
    }

    public function errors()
    {
        return $this->errors;
    }

    private function validateId()
    {
        if(!is_numeric($this->user->userId))
        {
            $this->errors['userID'] = 'UserId is Not a numeric attribute.';
        }
    }

    private function validateName()
    {
        if (!is_string($this->user->name))
        {
            $this->errors['name'] = 'Name is Not a string.';
        }
    }

    private function validateYearOfBirth()
    {
        $yearOfBirth = (int)$this->user->yearOfBirth;
        if($yearOfBirth < 1850 || $yearOfBirth > date("Y"))
        {
            $this->errors['yearOfBirth'] = 'Year Of Birth is Not a valid.';
        }
    }

    public function validateCreateUser()
    {
        $this->validateName();
        $this->validateYearOfBirth();

        return count($this->errors) === 0;
    }

    public function validateUser()
    {
        $this->validateId();

        return count($this->errors) === 0;
    }

    public function validateUpdateUser()
    {
        $this->validateId();
        $this->validateName();
        $this->validateYearOfBirth();

        return count($this->errors) === 0;
    }

}