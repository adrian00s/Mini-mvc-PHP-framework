<?php


    /**
     * Class ControllerMethodNotFoundException
     * Exception thrown if requested method doesn't exist in the requested controller
     * @author Adrian Iordache
     * @version 1.0
     */
    class ControllerMethodNotFoundException extends Exception {

        public function __construct($message = "", $code = 0, Throwable $previous = null){
            parent::__construct($message, $code, $previous);
        }
    }