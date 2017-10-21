<?php
/**
 * Created by PhpStorm.
 * User: bruno
 * Date: 21/10/2017
 * Time: 03:56
 */

namespace Exceptions;


use Exception;

class LoginInvalidException extends Exception
{
    public function __construct($message, $code = 0, Exception $previous = null) {

        parent::__construct($message, $code, $previous);
    }
}