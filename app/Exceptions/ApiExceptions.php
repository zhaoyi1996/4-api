<?php
namespace App\Exceptions;



class ApiExceptions extends \Exception{
    public function __construct($message='',$code=100)
    {
        parent::__construct($message ,$code);
    }



}