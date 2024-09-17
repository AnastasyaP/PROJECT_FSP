<?php
    include 'koneksi.php';

    if($_POST['btnSubmit']){
        // extract($_POST);
        $team = $_POST['team'];
        $achievement = $_POST['achievement'];
        $date = $_POST['date'];
        $description = $_POST['description'];
        $idachievement = $_POST['idachievement'];

        $stmt = $mysqli->prepare("UPDATE achievement SET idteam=?, name=?, date=?, description=? WHERE idachievement=?");
        $stmt->bind_param("isssi", $team, $achievement, $date, $description, $idachievement);
        $stmt->execute();

        //$jumlah = $stmt->affected_rows;

        $stmt->close();
    }
    $mysqli->close();

    header("Location: editachievement.php?idachievement=$idachievement&result=success");
?>