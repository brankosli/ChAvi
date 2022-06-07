<?php


namespace chAvio\Exceptions;


class ValidationException extends \Exception
{
    protected $validationErrors;

    public function setValidationErrors($errors=array()){
        $this->validationErrors = $errors;
    }

    public function getValidationErrors(){
        return $this->validationErrors;
    }

}