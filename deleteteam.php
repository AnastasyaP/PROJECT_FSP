<?php
    require_once('teamclass.php');

    $id = $_GET['idteam'];

    $team = new Team();

    $affected_rows = $team->deleteTeam($id);

    if($affected_rows > 0){
        header("Location: adminhome.php?deleted=success");
    } else {
        header("Location: adminhome.php?deleted=failed");
    }
?>