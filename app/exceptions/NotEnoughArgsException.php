<?php


    /**
     * Class thrown when the requested method doesn't receive the requested mandatory params
     * @author Adrian Iordache
     */
    class NotEnoughArgsException extends Exception{

        public function __construct($message = "", $code = 0, Throwable $previous = null){
            parent::__construct($message, $code, $previous);
        }

    }