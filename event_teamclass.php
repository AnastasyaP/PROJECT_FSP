<?php
    require_once("dbparent.php");

    class Event_Team extends DBParent{
        public function __construct(){
            parent::__construct();
        }

        public function readEventTeam(){
            $stmt = $this->mysqli->prepare("SELECT * FROM team");
            $stmt->execute();
            $res = $stmt->get_result();
            return $res;
        }

        public function insertEvenTeam($arrcol){
            if(!empty($arrcol)){
                $stmt = $this->mysqli->prepare("INSERT INTO event_teams(idevent,idteam) values(?,?)");
                $stmt->bind_param("ii", $idevent, $idteam);

                foreach($arrcol as $data){
                    $idevent = $data['idevent'];
                    $idteam = $data['idteam'];
                    $stmt->execute();
                }
                $stmt->close;
                return true;
            }else{
                return false;
            }

        }

        public function getEventTeam($idevent){
            $stmt = $this->mysqli->prepare("SELECT * FROM event_teams WHERE idevent = ?");
            $stmt->bind_param("i", $idevent);
            $stmt->execute();
            $result = $stmt->get_result();
            return $result;
        }

        public function deleteEvenTeam($id){
            $stmt= $this->mysqli->prepare("DELETE FROM event_teams WHERE idevent=?");
            $stmt->bind_param("i", $id);
            $stmt->execute();
            $res = $stmt->get_result();
            return $stmt->affected_rows;
        }

        // public function getTeamsByEventId($idevent) {
    
        //     $stmt = $mysqli->prepare("SELECT idteam FROM event_teams WHERE idevent = ?");
        //     $stmt->bind_param("i", $idevent);
        //     $stmt->execute();
        //     $result = $stmt->get_result();
    
        //     $teams = [];
        //     while ($team = $result->fetch_assoc()) {
        //         $teams[] = $team['idteam']; // Menambahkan idteam ke dalam array
        //     }
    
        //     $stmt->close();
        //     return $teams; 
        // }
    }
?>