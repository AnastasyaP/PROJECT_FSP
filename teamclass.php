<?php
    require_once("dbparent.php");

    class Team extends DBParent{
        public function __construct(){
            parent::__construct();
        }

        public function readTeam($keyword_name, $offset=null, $limit=null){
            $sql = "SELECT t.idteam, t.name as teamname, t.idgame, g.name as gamename FROM team t INNER JOIN game g ON t.idgame = g.idgame WHERE t.name LIKE ?";

            if(!is_null($offset)){
                $sql.= " LIMIT ?,?";
            }

            //echo "SQL Query: " . $sql;

            $stmt = $this->mysqli->prepare($sql);
            $keyword = "%{$keyword_name}%";

            //echo "Keyword: " . $keyword;

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
            $res = $this->readTeam($keyword_name);
            return $res->num_rows;
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

        public function getTeamById($idmember){
            $stmt = $this->mysqli->prepare("SELECT t.name as teamname,g.name as gamename from member as m inner join team_members tm 
                                   on m.idmember = tm.idmember inner join team t on tm.idteam = t.idteam
                                   inner join game as g on t.idgame = g.idgame
                                   where tm.idmember = ?");
            $stmt->bind_param("i",$idmember);
            $stmt->execute();
            $res= $stmt->get_result();
            return $res;
        }

        public function getMember($idmember,$idteam,$offset=null,$limit=null){
            $sql ="SELECT concat(m.fname,'',m.lname)as memberName,t.name as teamName from
                member as m inner join join_proposal as jn on
                m.idmember = jn.idmember inner join team as t on t.idteam = jn.idteam
                inner join team_members as tm on t.idteam = tm.idteam
                where tm.idmember = ? and jn.status = 'approved' and tm.idteam = ? ";
                
            if(!is_null($offset)){
                $sql.= " LIMIT ?,?";
            }

            $stmt = $this->mysqli->prepare($sql);

            if(!is_null($offset)){
                $stmt->bind_param("iiii",$idmember,$idteam, $offset, $limit);
            } else{
                $stmt->bind_param("ii", $idmember,$idteam);
            }
            // $stmt->bind_param("i",$idmember);

            $stmt->execute();
            $res = $stmt->get_result();
            return $res;
        }

        public function getTotalDatamemberTeam($idmember,$idteam){
            $res = $this->getMember($idmember,$idteam);
            return $res->num_rows;

        }
    }
?>