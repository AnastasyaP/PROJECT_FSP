<?php
    $mysqli = new mysqli("localhost", "root", "", "fullstack");
    if($mysqli->connect_errno){
        echo "Koneksi database gagal: " .$mysqli->connect_error;
        exit();
    }
?>