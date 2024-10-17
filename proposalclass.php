<?php
    require_once("dbparent.php");

    class Proposal extends DBParent{
        public function __construct(){
            parent::__construct();
        }

        public function getProposalWaiting($keyword_name, $offset=null, $limit=null){
            $sql = "SELECT jp.*, concat(m.fname,' ',m.lname)as member_name,t.name as team_name,m.idmember,t.idteam 
                from join_proposal as jp inner join member as m on jp.idmember = m.idmember
                inner join team as t on jp.idteam = t.idteam
                where jp.status = 'waiting' LIKE ?";

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
            $res = $stmt->get_result();
            return $res;
        }

        public function getTotalData($keyword_name){
            $res = $this->getProposalWaiting($keyword_name);
            return $res->num_rows;
        }

        public function UpdateStatusApoproved($id){
            $stmt = $this->mysqli->prepare(
                "UPDATE join_proposal SET status='approved' 
                where idjoin_proposal=?");
            $stmt->bind_param("i",$id);
            $stmt->execute();
            return $stmt->affected_rows;
        }

        public function UpdateStatusReject($id){
            $stmt = $this->mysqli->prepare(
                "UPDATE join_proposal SET status='rejected'
                WHERE idjoin_proposal=?");
            $stmt->bind_param("i",$id);
            $stmt->execute();    
            return $stmt->affected_rows; 
        }

        public function InsertTeamMembers($arrcol) {
            if (!empty($arrcol)) {
                $stmt = $this->mysqli->prepare("INSERT INTO team_members(idmember, idteam, description) VALUES (?, ?, ?)");
            
                $idmember = $arrcol['idmember'];
                $idteam = $arrcol['idteam'];
                $description = $arrcol['description'];
                
                $stmt->bind_param("iis", $idmember, $idteam, $description);
                $stmt->execute();
                $stmt->close();
                return true;
            } else {
                return false;
            }
        }

        public function getTeam(){
            $stmt = $this->mysqli->prepare("SELECT idteam, name FROM team");
            $stmt->execute();

            $res = $stmt->get_result();
            return $res;
        }

        public function insertJoinProposal($arrcol){
            $stmt = $this->mysqli->prepare("INSERT INTO join_proposal(idmember,idteam,description,status) value(?,?,?,'waiting')");
            $stmt->bind_param("iis",$arrcol['idmember'], $arrcol['idteam'], $arrcol['description']);
            if($stmt->execute()){
                return true;
            }else{
                echo"Error: ". $stmt->error;
                return false;
            }
            
        }

        public function getProposalbymember($idmember){
            $stmt = $this->mysqli->prepare(
                "SELECT jp.*, concat(m.fname,' ',m.lname)as member_name,t.name as team_name,m.idmember,t.idteam 
                from join_proposal as jp inner join member as m on jp.idmember = m.idmember
                inner join team as t on jp.idteam = t.idteam
                where jp.status = 'waiting' and m.idmember=?");

            $stmt->bind_param("i",$idmember);

            $stmt->execute();
            $res = $stmt->get_result();
            return $res;
        }

    }
?>