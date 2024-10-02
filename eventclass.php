<?php
    require_once("dbparent.php");

    class Event extends DBParent{
        public function __construct(){
            parent::__construct();
        }

        public function readEvent(){
            $stmt = $this->mysqli-> prepare("SELECT * from event");
            $stmt->execute();
            $result = $stmt->get_result();
            return $result;
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

    }
?>