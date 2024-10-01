<?php
    require_once('achievementclass.php');

    $id = $_GET['idachievement'];

    $achievement = new Achievement();

    $affected_rows = $achievement->deleteachievement($id);

    if($affected_rows > 0){
        header("Location: insertachievement.php?deleted=success");
    } else {
        header("Location: insertachievement.php?deleted=failed");
    }
?>