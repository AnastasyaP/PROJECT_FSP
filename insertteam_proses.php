<?php
    include 'koneksi.php';

    if($_POST['btnSubmit']){
        // extract($_POST);
        $team = $_POST['name'];
        $games = $_POST['game'];

        foreach($games as $game){
            $stmt = $mysqli->prepare(
                "INSERT INTO team(idgame, name) VALUES(?,?)"
            );
            $stmt->bind_param("is", $game, $team);
            $stmt->execute();
        }

        // $jumlah = $stmt->affected_rows;
        // $last_id = $stmt->insert_id;

        echo "Upload Successfull🎆";
        $stmt->close();
    }
    $mysqli->close();
    header("Location: insertteam.php?result=success");
?>