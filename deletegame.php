<?php
    include 'koneksi.php';

    $id = $_GET['idgame'];

    $stmt = $mysqli->prepare("DELETE FROM game WHERE idgame=?");
    $stmt->bind_param("i",$id);
    $stmt->execute();
    //$res = $stmt->get_result();

    //$row = $res->fetch_assoc();

    if($stmt->affected_rows > 0){
        echo "Deleted Succsessfull😆";
    } else {
        echo "Failed to delete data";
    }

    $stmt->close();
    $mysqli->close();

    header("Location: insertgame.php");
    exit();
?>