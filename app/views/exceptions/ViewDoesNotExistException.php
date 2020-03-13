<?php


    /**
     * Class ViewDoesNotExistException
     * Exception thrown whenever the requested view does not exist
     * @author Adrian Iordache
     * @version 1.0
     */
    class ViewDoesNotExistException extends Exception{
        public function __construct($message = "", $code = 0, Throwable $previous = null){
            parent::__construct($message, $code, $previous);
        }
    }