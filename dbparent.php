<?php
    require_once("data.php");
    class DBParent{
        protected $mysqli;

        public function __construct(){
            $this->mysqli = new mysqli(SERVER_NAME, USER_NAME, PASSWORD, DB_NAME);
            if($this->mysqli->connect_errno){
                echo"Koneksi database gagal: " .$this->mysqli->connect_error;
                exit();
            }
        }
    }
?>