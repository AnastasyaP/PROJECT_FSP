<?php
    require_once("dbparent.php");

    class Member extends DBParent{
        public function __construct(){
            parent::__construct();
        }

        public function checkLogin($arrcol){
            $sql = "SELECT CONCAT(fname,' ', lname) as name FROM member WHERE username = ? and password = ?";    
            $stmt = $this->mysqli->prepare($sql);
            $stmt->bind_param("ss", $arrcol['username'], $arrcol['password']);

            $stmt->execute();
            $res = $stmt->get_result();
            return $res;
        }

        public function insertMember($arrcol){
            $stmt = $this->mysqli->prepare("INSERT INTO member(fname,lname,username,password,profile) values(?,?,?,?,?)");
            $stmt->bind_param("sssss", $arrcol['fname'], $arrcol['lname'], $arrcol['username'], $arrcol['password'], $arrcol['profile']);
            $stmt->execute();
            return $this->mysqli->insert_id;        
        }   
    }    
?>