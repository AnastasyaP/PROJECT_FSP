<?php
    require_once('dbparent.php');

    class Achievement extends DBParent{
        public function __construct(){
            parent::__construct();
        }

        public function readAchievement($keyword_name, $offset=null, $limit=null){
            $sql = "SELECT a.idachievement, a.idteam, a.name as achievename, a.description, a.date, t.idteam, t.name as teamname
                    FROM achievement a INNER JOIN team t ON a.idteam = t.idteam WHERE a.name LIKE ?";

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
            $res = $this->readAchievement($keyword_name);
            return $res->num_rows;
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

        public function getAchievementBymember($idmember,$offset=null, $limit = null){
            $sql ="SELECT a.name, a.date, a.description
                                            from member m inner join team_members tm on m.idmember = tm.idmember
                                            inner join team t on tm.idteam = t.idteam
                                            inner join achievement a on t.idteam = a.idteam
                                            where m.idmember = ?";
            if(!is_null($offset)){
                $sql.= " LIMIT ?,?";
            }

            $stmt = $this->mysqli->prepare($sql);

            if(!is_null($offset)){
                $stmt->bind_param("iii", $idmember, $offset, $limit);
            } else{
                $stmt->bind_param("i", $idmember);
            }
            // $stmt->bind_param("i",$idmember);

            $stmt->execute();
            $res = $stmt->get_result();
            return $res;
        }

        public function getTotalDataAchievement($idmember){
            $res = $this->getAchievementBymember($idmember);
            return $res->num_rows;
        }
    }
?>