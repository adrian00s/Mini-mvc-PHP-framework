<?php

    /**
     * Class ControllerDoesNotExistException
     * Thrown if the requested controller doesn't exist
     * @author Adrian Iordache
     * @version 1.0
     */
    class ControllerDoesNotExistException extends Exception {
        public function __construct($message = "", $code = 0, Throwable $previous = null){
            parent::__construct($message, $code, $previous);
        }
    }