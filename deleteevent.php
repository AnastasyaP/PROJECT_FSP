<?php
    include 'koneksi.php';

    $id = $_GET['idevent'];

    $stmt = $mysqli->prepare("DELETE FROM event WHERE idevent=?");
    $stmt->bind_param("i",$id);
    $stmt->execute();
    $stmt->close();

    $stmt2 = $mysqli->prepare("DELETE FROM event_teams where idevent=?");
    $stmt2->bind_param("i",$id);
    $stmt2->execute();


    if($stmt2->affected_rows > 0){
        echo "Deleted Succsessfull😆";
    } else {
        echo "Failed to delete data";
    }

    $stmt2->close();
    $mysqli->close();
    header("Location: inserteventnew.php");
    exit();
?>