<?php


    class Index extends Controller{
        private $indexModel = null;

        public function __construct(){
            parent::__construct();
            $this->indexModel = $this->model("Index/IndexM");
        }

        public function index() :void{

            try{
                self::renderView("Index/index", ["example" => "straight from controller!"]);
            }catch(ViewDoesNotExistException $e){
                echo $e->getMessage();
                exit();
            }
        }
    }