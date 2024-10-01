<?php
    require_once('dbparent.php');

    class Achievement extends DBParent{
        public function __construct(){
            parent::__construct();
        }

        public function readAchievement(){
            $sql = "SELECT a.idachievement, a.idteam, a.name as achievename, a.description, a.date, t.idteam, t.name as teamname
                    FROM achievement a INNER JOIN team t ON a.idteam = t.idteam";
            $stmt = $this->mysqli->prepare($sql);
            $stmt->execute();
            $result = $stmt->get_result();
            return $result;
        }

        public function insertAchievement($arrcol){
            $stmt = $this->mysqli->prepare("INSERT INTO achievement(idteam, name, date, description) VALUES(?,?,?,?)");
            $stmt->bind_param("isss", $arrcol['idteam'], $arrcol['name'], $arrcol['date'], $arrcol['description']);
            $stmt->execute();
            return $this->mysqli->insert_id;
        }

        public function deleteAchievement($id){
            $stmt = $this->mysqli->prepare("DELETE FROM achievement WHERE idachievement = ?");
            $stmt->bind_param("i", $id);
            $stmt->execute();
            $result = $stmt->get_result();
            return $stmt->affected_rows;
        }
    }
?>