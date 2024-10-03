<?php
    $mysqli = new mysqli("localhost", "root", "", "esport");
    if($mysqli->connect_errno){
        echo "Koneksi database gagal: " .$mysqli->connect_error;
        exit();
    }
?>