<?php
    require_once("dbparent.php");

    class Proposal extends DBParent{
        public function __construct(){
            parent::__construct();
        }

        public function getProposalWaiting(){
            $stmt = $this->mysqli->prepare(
                "SELECT jp.*, concat(m.fname,' ',m.lname)as member_name,t.name as team_name
                from join_proposal as jp inner join member as m on jp.idmember = m.idmember
                inner join team as t on jp.idteam = t.idteam
                where jp.status = 'waiting'");
    
            $stmt->execute();

            // Ambil hasilnya
            $res = $stmt->get_result();

            // Kembalikan hasil
            return $res;
        }
    }


?>