<?php
    require_once("dbparent.php");

    class Team extends DBParent{
        public function __construct(){
            parent::__construct();
        }

        public function readTeam(){
            $sql = "SELECT t.idteam, t.name as teamname, t.idgame, g.name as gamename FROM team t INNER JOIN game g ON t.idgame = g.idgame";
            $stmt = $this->mysqli->prepare($sql);
            $stmt->execute();
            $result = $stmt->get_result();
            return $result;
        }

        public function insertTeam($arrcol){
            $stmt = $this->mysqli->prepare("INSERT INTO team(idgame, name) VALUES(?,?)");
            $stmt->bind_param("is", $arrcol['idgame'], $arrcol['name']);
            $stmt->execute();
            return $this->mysqli->insert_id;
        }

        public function deleteTeam($id){
            $stmt = $this->mysqli->prepare("DELETE FROM team WHERE idteam = ?");
            $stmt->bind_param("i", $id);
            $stmt->execute();
            $result = $stmt->get_result();
            return $stmt->affected_rows;
        }

        public function updateTeam($arrcol, $id){
            $stmt = $this->mysqli->prepare("UPDATE team SET idgame = ?, name = ? WHERE idteam = ?");
            $stmt->bind_param("ssi", $arrcol['idgame'], $arrcol['name'], $id);
            $stmt->execute();
            return $stmt->affected_rows;
        }

        public function getTeam($id){
            $stmt = $this->mysqli->prepare("SELECT * FROM team WHERE idteam = ?");
            $stmt->bind_param("i", $id);
            $stmt->execute();
            $res = $stmt->get_result();
            return $res;
        }

        public function getGame(){
            $stmt = $this->mysqli->prepare("SELECT idgame, name FROM game");
            $stmt->execute();
            
            $res = $stmt->get_result();
            return $res;
        }
    }
?>