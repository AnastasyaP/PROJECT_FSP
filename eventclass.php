<?php
    require_once("dbparent.php");

    class Event extends DBParent{
        public function __construct(){
            parent::__construct();
        }

        public function readEvent($keyword_name, $offset=null, $limit=null){
            $sql = "SELECT * from event WHERE name LIKE ?";

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
            $res = $this->readEvent($keyword_name);
            return $res->num_rows;
        }

        public function insertEvent($arrcol){
            $stmt =$this->mysqli->prepare("INSERT INTO event(name,date,description) values(?,?,?)");
            $stmt->bind_param("sss", $arrcol['name'],$arrcol['date'],$arrcol['description']);
            $stmt->execute();
            return $this->mysqli->insert_id;
        }

        public function getEvent($id){
            $stmt = $this->mysqli->prepare("SELECT * FROM event WHERE idevent = ?");
            $stmt->bind_param("i", $id);
            $stmt->execute();
            $res = $stmt->get_result();
            return $res;
        }

        public function updateEvent($id, $arrcol){
            $stmt = $this->mysqli->prepare("UPDATE event SET name=?, date=?, description=? WHERE idevent=?");
            $stmt->bind_param("sssi", $arrcol['name'], $arrcol['date'],$arrcol['description'], $id);
            $stmt->execute();
        }

        public function deleteEvent($id){
            $stmt = $this->mysqli->prepare("DELETE FROM event WHERE idevent=?");
            $stmt->bind_param("i",$id);
            $stmt->execute();
            return $stmt->affected_rows;
        }

        public function getEventByID($idmember){
            $stmt = $this->mysqli->prepare("SELECT e.name, e.date, e.description
                                        from member m inner join team_members tm
                                        on m.idmember = tm.idmember inner join team t
                                        on tm.idteam = t.idteam inner join event_teams et
                                        on t.idteam = et.idteam inner join event e
                                        on e.idevent = et.idevent
                                        where m.idmember = ?");
            $stmt->bind_param("i",$idmember);
            $stmt->execute();
            $res= $stmt->get_result();
            return $res;
        }

    }
?>