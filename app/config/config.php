<?php

    /**
     * Define config constants
     * @author Adrian Iordache
     */
    define("APPROOT", dirname(dirname(__FILE__)));
    define("URLROOT", "http://localhost:8012/");
    define("SITENAME", "MVC Example");

    # Database constants vars
    define("DB_HOST", "HOST");
    define("DB_USER", "USERNAME");
    # Database user password
    define("DB_UPWD", "PASSWORD");
    define("DB_NAME", "DATABASE");

    # Logs related configuration
    define("SQL_ERROR", 1);

    # Path to log file for sql errors
    define("SQL_ERROR_PATH", "C:\Users\adior\Desktop\projects-php\mvc-example\app\logs\sql-state.log");
    define("STANDARD_SQL_ERROR_MESSAGE", "<h1>There was an error with SQL. Please check log file</h1>");
