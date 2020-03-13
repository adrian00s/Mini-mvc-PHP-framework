<?php


    /**
     * Class IndexM. Represents the model of Index.
     * @author Adrian Iordache
     * @version 1.0
     */
    class IndexM extends Model{
        private $db;

        public function __construct(){
            #$this->db = new Database;
        }

        public function getTestData() : array{
            try{
                $this->db->query("SELECT * FROM test WHERE id = :id");
                $this->db->bind(":id", 1);
                $this->db->execute();
            } catch(Exception $e){
                $this->executeActionOnErrorType($e->getMessage());
                exit();
            }

            return $this->db->fetchAll();
        }
    }