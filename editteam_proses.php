<?php
    include 'koneksi.php';

    if($_POST['btnSubmit']){
        extract($_POST);

        $stmt = $mysqli->prepare("UPDATE team SET name=? WHERE idteam=?");
        $stmt->bind_param("si", $name, $idteam);
        $stmt->execute();

        //$jumlah = $stmt->affected_rows;

        $stmt->close();
    }
    $mysqli->close();

    header("Location: editteam.php?idteam=$idteam&result=success");
?>