<?php

    /**
     * Creates the URL and loads core controller
     * URL FORMAT - /controller/method/params
     * @author Adrian Iordache
     * @version 1.0
     */

    require_once "../app/controllers/exceptions/ControllerDoesNotExistException.php";
    require_once "../app/controllers/exceptions/ControllerMethodNotFoundException.php";
    require_once "../app/exceptions/AccessForbiddenException.php";
    require_once "../app/exceptions/NotEnoughArgsException.php";

    class Core{
        // Set protected methods to change this
        private $controllerName = "Index";
        private $controllerObject = null;
        private $currentMethod = "index";
        private $params = [];


        public function __construct(){
            try {
                $this->initController();
            } catch (Exception $e) {
                echo $e->getMessage();
                exit();
            } catch (ArgumentCountError $e){
                try{
                    Controller::renderView("InsufficientArgs/index");
                    throw new NotEnoughArgsException();
                } catch (NotEnoughArgsException | ViewDoesNotExistException $e){
                    if ($e instanceof ViewDoesNotExistException) echo $e->getMessage();
                    exit();
                }
            }
        }

        /**
         * Get the url if is setted
         * @return array Array with the default controller name if is not set, else the url as an array
         */
        private function getUrl() :array{
            $isSetURL = $this->urlExists();

            if ($isSetURL) {
                return explode("/", filter_var(rtrim($_GET["url"], "/"), FILTER_SANITIZE_URL));
            }

            return [$this->controllerName];
        }

        /**
         * Instantiate the appropriate Controller or throws exception
         * @throws ControllerDoesNotExistException thrown in case the controller doesn't exist
         * the requested controller
         */
        private function initController() : void{
            $url = $this->getUrl();

            if (file_exists("../app/controllers/" . ucwords($url[0]) . ".php")){
                $this->controllerName = ucwords($url[0]);
                unset($url[0]);

                require_once "../app/controllers/" . $this->controllerName . ".php";

                try{
                    $this->controllerObject = new $this->controllerName;

                    if ($this->hasMethod()){
                        $this->loadMethod($url);
                    }else{
                        # Load default method
                        if (method_exists($this->controllerObject, $this->currentMethod)){
                            $this->controllerObject->{$this->currentMethod}();

                            // Uncomment if index is protected o private
                            /*try{
                                $this->controllerObject->{$this->currentMethod}();
                            } catch (Throwable $e){
                                if (strpos($e->getMessage(), "protected") || strpos($e->getMessage(), "private")){
                                    try{
                                        Controller::renderView("Forbidden/index");
                                        throw new AccessForbiddenException();
                                    }catch(Exception $e){
                                        if ($e instanceof ViewDoesNotExistException) echo $e->getMessage();
                                        exit();
                                    }
                                }
                            }*/
                        }else{
                            throw new ControllerDoesNotExistException("The file you are requesting doesn't exist");
                        }

                    }

                } catch (ControllerMethodNotFoundException $e){
                    echo $e->getMessage();
                    exit();
                }

            }else{

                try{
                    Controller::renderView("InexistentController/index");
                    throw new ControllerDoesNotExistException();
                }catch (Exception $e){
                    if ($e instanceof ViewDoesNotExistException) echo $e->getMessage();
                    exit();
                }

            }
        }

        /**
         * Private method that loads the request controller if exists
         * @param $url array url coming from InitController (with first value unset)
         * @throws ControllerMethodNotFoundException Thrown in case the requested method is not present in
         * the requested controller
         */
        private function loadMethod($url) : void{
            $this->currentMethod = $url[1];

            if (method_exists($this->controllerObject, $this->currentMethod)){
                /*
                 * Unset the method name because call_user_func_array takes the first
                 * value(url[1]) which is the method name. Unset that, and now we only have
                 * the params.
                 */
                unset($url[1]);

                $this->params = (isset($url) ? array_values($url) : []);

                /*
                 * To catch ArgumentCountError exception you can:
                 * 1.- Define default values for parameters
                 * 2.- Catch the exception: ArgumentCountError
                 */

                try{

                    /*
                     * If index does not exist, you wont be able to use any controller functionality
                     * even if that functionality exist
                     */
                    if (!method_exists($this->controllerObject, "index")){
                      throw new AccessForbiddenException();
                    }

                    if ($this->currentMethod == "renderview"){
                        throw new AccessForbiddenException();
                    }

                    call_user_func_array([$this->controllerObject, $this->currentMethod], $this->params);
                } catch (Exception $e){

                    if ($e instanceof AccessForbiddenException){
                        try {
                            Controller::renderView("Forbidden/index");
                        } catch (ViewDoesNotExistException $e) {
                            echo $e->getMessage();
                            exit();
                        }
                    }else{
                        if (strpos($e->getMessage(), "protected") || strpos($e->getMessage(), "private")){
                            try{
                                Controller::renderView("Forbidden/index");
                                throw new AccessForbiddenException();
                            }catch(Exception $e){
                                if ($e instanceof ViewDoesNotExistException) echo $e->getMessage();
                                exit();
                            }
                        }
                    }
                }

            }else{
                throw new ControllerMethodNotFoundException("The requested functionality doesn't exist");
            }
        }

        private function hasMethod() : bool{
            return isset($this->getUrl()[1]);
        }

        /**
         * Check that the URL is set
         * @return bool returns true if 'url' is set, else false
         */
        private function urlExists() : bool{
            return isset($_GET["url"]);
        }
    }