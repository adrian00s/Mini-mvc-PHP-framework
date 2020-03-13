<?php

    /**
     * This function catches warnings so you can catch it as an exception
     * @param bool $catch true or false. By default, warnings will be caught
     */
    function catchWarnings(bool $catch){
        if ($catch){
            set_error_handler(function ($severity, $message, $file, $line) {
                throw new \ErrorException($message, $severity, $severity, $file, $line);
            });
        }
    }
