<?php


    /**
     * Represents the Database.
     * This class is just a wrapper around PDO
     * @author Adrian Iordache
     * @version 1.0
     */
    class Database{
        private $host       = DB_HOST;
        private $user       = DB_USER;
        private $userPswd   = DB_UPWD;
        private $dbName     = DB_NAME;
        private $PDOObject;
        private $stmt;
        private $errorMessage;

        public function __construct(){
            $dsn = "mysql:host=" . $this->host . ";dbname=" . $this->dbName;

            $options = [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION];

            try{
                $this->PDOObject = new PDO($dsn, $this->user, $this->userPswd, $options);
            }catch(PDOException $e){
                $this->errorMessage = $e->getMessage();

                Model::executeActionOnErrorType($this->errorMessage);
                exit();
            }
        }

        public function query($query) : void{
            $this->stmt = $this->PDOObject->prepare($query);
        }

        /**
         * Bind parameters in case any exist.
         * @param $param string The param you want to bind
         * @param $value mixed The value of that param
         * @param null $type The type. Do not include it. It should be null always.
         * The method will automatically detect the type.
         */
        public function bind($param, $value, $type = null) : void{
            if (is_null($type)){
                switch (true){
                    case is_int($value): {
                        $type = PDO::PARAM_INT;
                        break;
                    }
                    case is_bool($value) : {
                        $type = PDO::PARAM_BOOL;
                        break;
                    }
                    case is_null($value) : {
                        $type = PDO::PARAM_NULL;
                        break;
                    } default: {
                        $type = PDO::PARAM_STR;
                    }
                }

                $this->stmt->bindValue($param, $value, $type);
            }
        }

        public function execute() : bool{
            return $this->stmt->execute();
        }

        public function fetchAll() : array{
            $this->execute();
            return $this->stmt->fetchAll(PDO::FETCH_OBJ);
        }

        public function fetch() : array{
            $this->execute();
            return $this->stmt->fetch(PDO::FETCH_OBJ);
        }
    }