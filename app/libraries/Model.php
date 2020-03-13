<?php


    /**
     * Abstract model class. All models must extend this class.
     * Implement logic that will be shared across all models.
     * NOTE: All extending models must include an "M" after definiton.
     * Example: PersonalM. Would represent Personal Model bound to Personal Controller and view
     * @author Adrian Iordache
     * @version 1.0
     */
    abstract class Model{

        /**
         * Static utility method used to write to a log file
         * @param $logFile string The log file. Please include absolute path to avoid problems
         * @param $logMessage string The log message. Usually, it comes from an exception
         */
        private static function writeToLogFile($logFile, $logMessage) : void{
            $openFile = fopen($logFile, "a+");

            date_default_timezone_set("Europe/Madrid");

            $dateNow = date("d/M/Y H:i:s");

            fwrite($openFile, $dateNow . " > " . $logMessage ."\n");
        }

        /**
         * Static utility method used to identify the error type.
         * @param $message string The message. The message will be analyzed to identify the probelm
         * @return int the integer bound to the error. 0 if the error is not recognized.
         */
        private static function identifyErrorType($message) : int{
            if (strpos($message, "SQLSTATE") !== false){
                return SQL_ERROR;
            }

            return 0;
        }

        /**
         * Public utility message used to execute an action depending on the error type.
         * Typically, the action is writing to a log file
         * @param $message string The message to be written to the log file. It comes from an exception
         */
        public static function executeActionOnErrorType($message) : void{
            $errorType = self::identifyErrorType($message);

            # Add more cases depending on the error type or implement a dynamic switch case
            switch ($errorType){
                case SQL_ERROR: {
                    self::writeToLogFile(SQL_ERROR_PATH, $message);

                    # Display informative message
                    echo STANDARD_SQL_ERROR_MESSAGE;
                    break;
                }
            }
        }
    }