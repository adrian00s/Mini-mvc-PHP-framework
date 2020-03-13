<?php

    require_once "../app/views/exceptions/ViewDoesNotExistException.php";
    require_once "../app/helpers/catchWarnings.php";

    /**
     * Base Controller. All controller must extend this class.
     * Implement logic that will be shared across multiple controllers.
     * @author Adrian Iordache
     * @version 1.0
     */
    abstract class Controller{

        protected function __construct(){
            // Disable if you dont want to catch warnings
            // Careful: There is logic implemented that catches warnings
            catchWarnings(true);
        }

        /**
         * @param $model string Model name. Must be: Folder/Class NOTE: Folder must be
         * named exactly as the model name
         * @return null in case the request model doesn't exist
         */
        protected function model($model){
            if (file_exists("../app/models/" . $model . ".php")){
                require_once "../app/models/" . $model . ".php";

                $model = explode("/", $model);
                $model = end($model);

                return new $model;
            }

            return null;
        }

        /**
         * @param $view string The name of the view
         * @param array $data The data to be rendered in the view (optional)
         * @throws ViewDoesNotExistException Thrown whenever the requested view
         * does not exist.
         */
        public static function renderView($view, $data = []){
            if (file_exists("../app/views/" . $view . ".php")){
                require_once "../app/views/" . $view . ".php";
            }else{
                throw new ViewDoesNotExistException("404 Not Found");
            }
        }
    }