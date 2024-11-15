<?php
    require_once("dbparent.php");

    class Game extends DBParent{
        public function __construct(){
            parent::__construct();
        }

        public function readGame($keyword_name, $offset=null, $limit=null){
            $sql = "SELECT * from game WHERE name LIKE ?";

            if(!is_null($offset)){
                $sql.= " LIMIT ?,?";
            }

            $stmt = $this->mysqli->prepare($sql);
            $keyword = "%{$keyword_name}%";

            if(!is_null($offset)){
                $stmt->bind_param("sii", $keyword, $offset, $limit);
            } else{
                $stmt->bind_param("s", $keyword);
            }

            $stmt->execute();
            $result = $stmt->get_result();
            return $result;
        }

        public function getTotalData($keyword_name){
            $res = $this->readGame($keyword_name);
            return $res->num_rows;
        }

        public function readGameById($id){
            $sql = "SELECT * from game Where idgame = ?";
            $stmt = $this->mysqli->prepare($sql);
            $stmt->bind_param("i", $id);
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

        public function deleteGame($id){
            $stmt =$this->mysqli->prepare("DELETE FROM game WHERE idgame=?");
            $stmt->bind_param("i",$id);
            $stmt->execute();
            $res = $stmt->get_result();
            return $stmt->affected_rows;
        
        }

        public function updateGame($id, $arrcol){
            $stmt = $this->mysqli->prepare("UPDATE game SET name=?, description=? WHERE idgame=?");
            $stmt->bind_param("ssi",$arrcol['name'], $arrcol['description'],$id);
            $stmt->execute();
            return $stmt->affected_rows;
        }
    }
?>