<?php


    /**
     * Class AccessForbiddenException
     * Thrown in case user is trying to access a private/protected method
     * @author Adrian Iordache
     * @version 1.0
     */
    class AccessForbiddenException extends Exception {
        public function __construct($message = "", $code = 0, Throwable $previous = null){
            parent::__construct($message, $code, $previous);
        }
    }