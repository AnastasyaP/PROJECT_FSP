<?php
    include 'koneksi.php';

    $id = $_GET['idteam'];

    $stmt = $mysqli->prepare("DELETE FROM team WHERE idteam=?");
    $stmt->bind_param("i",$id);
    $stmt->execute();
    $res = $stmt->get_result();

    //$row = $res->fetch_assoc();

    if($stmt->affected_rows > 0){
        echo "Deleted Succsessfull😆";
    } else {
        echo "Failed to delete data";
    }

    $stmt->close();
    $mysqli->close();
?>