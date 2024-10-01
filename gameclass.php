<?php
    require_once("dbparent.php");

    class Game extends DBParent{
        public function __construct(){
            parent::__construct();
        }

        public function readGame(){
            $sql = "SELECT * from game";
            $stmt = $this->mysqli->prepare($sql);
            $stmt->execute();
            $result = $stmt->get_result();
            return $result;
        }

        public function insertGame($arrcol){
            $stmt = $this->mysqli->prepare("INSERT INTO game(name,description) values(?,?)");
            $stmt->bind_param("ss",$arrcol['name'], $arrcol['description']);
            $stmt->execute();
            return $this->mysqli->insert_id;
        }
    }
?>