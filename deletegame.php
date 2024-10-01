<?php
    require_once('gameclass.php');

    $id = $_GET['idgame'];

    $game = new Game();

    $affected_rows = $game->deleteGame($id);

    if($affected_rows > 0){
        header("Location: insertgamenew.php?status=success");
    } else {
        header("Location: insertgamenew.php?status=failure");
    }
    exit();
?>