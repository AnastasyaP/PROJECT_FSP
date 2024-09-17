<?php
    include 'koneksi.php';

    if($_POST['btnSubmit']){
        $team = $_POST['team'];
        $name = $_POST['achievement'];
        $date = $_POST['date'];
        $description = $_POST['description'];

        $stmt = $mysqli->prepare("INSERT INTO achievement(idteam, name, date, description) VALUES(?,?,?,?)");
        $stmt->bind_param("isss", $team, $name, $date, $description);
        $stmt->execute();

        echo "Upload Successfull🎆";
    }
?>