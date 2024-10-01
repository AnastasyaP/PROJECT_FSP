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
    }
?>