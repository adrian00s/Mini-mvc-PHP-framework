<?php

    # Require config constants
    require_once "config/config.php";

    #Require helpers

    // Require Core, Base Controller and DB via autoloader

    /*
     *   require_once "libraries/Core.php";
     *   require_once "libraries/Controller.php";
     *   require_once "libraries/Database.php";
     */
    spl_autoload_register(function($className){
        require_once "libraries/" . $className . ".php";
    });
