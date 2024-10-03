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

        public function updateAchievement($arrcol, $id){
        $stmt = $this->mysqli->prepare("UPDATE achievement SET idteam=?, name=?, date=?, description=? WHERE idachievement=?");
        $stmt->bind_param("ssssi", $arrcol['idteam'], $arrcol['name'], $arrcol['date'], $arrcol['description'], $id);
        $stmt->execute();
        return $stmt->affected_rows;
        }

        public function getAchievement($id){
            $stmt = $this->mysqli->prepare("SELECT * FROM achievement WHERE idachievement=?");
            $stmt->bind_param("i", $id);
            $stmt->execute();
            $res = $stmt->get_result();
            return $res;
        }

        public function getTeam(){
            $stmt = $this->mysqli->prepare("SELECT idteam, name FROM team");
            $stmt->execute();

            $res = $stmt->get_result();
            return $res;
        }

        public function getDescription(){
            $stmt = $this->mysqli->prepare("SELECT idteam, name FROM team");
            $stmt->execute();

            $res = $stmt->get_result();
            return $res;
        }
    }
?>